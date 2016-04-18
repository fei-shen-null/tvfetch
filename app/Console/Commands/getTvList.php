<?php

namespace App\Console\Commands;

use App\Sub2NewTv;
use App\Tv;
use App\TvList;
use Illuminate\Console\Command;
use Mail;

class getTvList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tv:getList {uri=http://cn163.net/2014the-tv-show/}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch current tv list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uri = $this->argument('uri');
        $doc = new \DOMDocument('1.0', 'UTF8');
        $internalErrors = libxml_use_internal_errors(true);
        $doc->loadHTML(file_get_contents($uri));
        libxml_use_internal_errors($internalErrors);
        $trs = $doc->getElementsByTagName('tr');
        $dayOfWeek = 0;
        $newTV = [];
        $newList = [];
        foreach ($trs as $key => $tr) {
            if ($key == 0) continue;
            $tds = $tr->childNodes;
            if (str_contains($tds->item(0)->nodeValue, '周')) {
                $dayOfWeek++;
                continue;
            }
            preg_match('/archives\/(?P<id>.+)\//', $tds->item(0)->firstChild->getAttribute('href'), $tvID);
            $tv = array(
                'id' => intval($tvID['id']),
                'day_of_week' => $dayOfWeek,
                'name_cn' => $tds->item(0)->firstChild->nodeValue,
                'name_en' => $tds->item(2)->nodeValue,
                'channel' => $tds->item(4)->nodeValue,
                'genre' => $tds->item(6)->nodeValue,
                'status' => $tds->item(8)->nodeValue
            );
            $newList[] = $tv['id'];
            $tvMod = Tv::find($tv['id']);
            if (is_null($tvMod)) {//insert tv
                $newTV[] = $tv;//new tv to push
                Tv::create($tv);//insert tv
            } else {//update tv
                $tvMod->fill($tv);
                $tvMod->save();
            }
            //update tv_list
            TvList::firstOrCreate(['tv_id' => $tv['id']]);
        }
        //remove old tv_list
        TvList::whereNotIn('tv_id', $newList)->delete();
        //notify new tv to users
        if (!empty($newTV)) {
            $users = Sub2NewTv::Join('users', (new Sub2NewTv)->getTable() . '.user_id', '=', 'users.id')->pluck('email', 'id')->all();
            foreach (array_chunk($users, env('MAIL_TO_LIMIT', 1000), true) as $userChunk) {
                Mail::queue('emails.newtv', ['newTv' => $newTV], function ($m) use ($userChunk) {
                    $m->from('do-not-reply@sp.shenfei.science');
                    $m->cc($userChunk)->subject('New Tv Arrived');
                }, 'email');
            }
        }
        echo 'getList:' . sizeof($newList);
    }
}
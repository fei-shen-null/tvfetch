<?php

namespace App\Console\Commands;

use App\Sub2NewTv;
use App\Tv;
use App\TvList;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;
use Mail;

class getTvList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tv:getList {uri=http://cn163.net/2014the-tv-show/} {--skipMails}';

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
        $options = array(
            'http' => array(
                'method' => "GET",
                'header' =>
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.10 Safari/537.36"
            )
        );
        $context = stream_context_create($options);
        $html = file_get_contents($uri, false, $context);
        if ($html === false) {
            Log::error('Cannot fetch tv list.');
            die();
        }
        $doc->loadHTML($html);
        $xpath = new \DOMXpath($doc);
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
            $link = $xpath->query('.//td[contains(@class, "column-1")]/a',$tr)->item(0);
            if (empty($link) || ($link instanceof \DOMText)) continue;//missing a href will result in a DOMText
            $href = $link->getAttribute('href');
            preg_match('/archives\/(?P<id>.+)\//', $href, $tvID);
            $tv = array(
                'id' => intval($tvID['id']),
                'day_of_week' => $dayOfWeek,
                'name_cn' => $xpath->query('.//td[contains(@class, "column-1")]/a',$tr)->item(0)->nodeValue,
                'name_en' => $xpath->query('.//td[contains(@class, "column-2")]',$tr)->item(0)->nodeValue,
                'channel' =>$xpath->query('.//td[contains(@class, "column-3")]',$tr)->item(0)->nodeValue,
                'genre' => $xpath->query('.//td[contains(@class, "column-4")]',$tr)->item(0)->nodeValue,
                'status' => $xpath->query('.//td[contains(@class, "column-5")]',$tr)->item(0)->nodeValue
            );
            print_r($tv);
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
        if (!empty($newTV) && !$this->option('skipMails')) {
            $users = Sub2NewTv::Join('users', (new Sub2NewTv)->getTable() . '.user_id', '=', 'users.id')->pluck('email', 'id')->all();
            foreach (array_chunk($users, config('tvfetch.MAIL_TO_LIMIT', 1000), true) as $userChunk) {
                Mail::queueOn('newTvMail', 'emails.newtv', ['newTv' => $newTV], function ($m) use ($userChunk) {
                    $m->from(config('tvfetch.MAIL_FROM'));
                    $m->cc($userChunk)->subject('New Tv Arrived');
                });
            }
        }
        unset($html, $doc, $trs);
        echo 'getList:' . sizeof($newList) . ' new tv' . sizeof($newTV) . '@' . Carbon::now()->toRssString() . PHP_EOL;
    }
}
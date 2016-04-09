<?php

namespace App\Console\Commands;

use App\Tv;
use Illuminate\Console\Command;

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
    protected $description = 'get current tv list';

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
        foreach ($trs as $key => $tr) {
            if ($key == 0) continue;
            $tds = $tr->childNodes;
            if (str_contains($tds->item(0)->nodeValue, '周')) {
                $dayOfWeek++;
                continue;
            }
            preg_match('/archives\/(?P<id>.+)\//', $tds->item(0)->firstChild->getAttribute('href'), $tvID);
            $tv = array(
                'tv_id' => $tvID['id'],
                'day_of_week' => $dayOfWeek,
                'name_cn' => $tds->item(0)->firstChild->nodeValue,
                'name_en' => $tds->item(2)->nodeValue,
                'channel' => $tds->item(4)->nodeValue,
                'genre' => $tds->item(6)->nodeValue,
                'status' => $tds->item(8)->nodeValue
            );
            Tv::firstOrCreate($tv);
        }

    }
}

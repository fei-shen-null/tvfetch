<?php

namespace App\Console\Commands;

use App\Jobs\getTvEpisodes;
use App\Tv;
use App\TvList;
use Carbon\Carbon;
use Illuminate\Console\Command;

class getEpisodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tv:getEpisodes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check new episodes for all TVs';

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
        $tvList = TvList::all();
        foreach ($tvList as $tv) {
            dispatch((new getTvEpisodes(Tv::findOrFail($tv->tv_id)))->onQueue('getTvEpisodes'));
        }
        echo 'getTvEpisodes@' . Carbon::now()->toRssString();
    }
}

<?php

namespace App\Jobs;

use App\Episode;
use App\Tv;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class getTvEpisodes extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $tv;

    /**
     * Create a new job instance.
     *
     * @param Tv $tv
     */
    public function __construct(Tv $tv)
    {
        $this->tv = $tv;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uri = config('tvfetch.TVFETCH_SOURCE') . $this->tv->id;
        $html = file_get_contents($uri);
        if ($html === false) {
            Log::error('Cannot download tv id=' . $this->tv->id);
        }
        $doc = new \DOMDocument('1.0', 'UTF8');
        $internalErrors = libxml_use_internal_errors(true);
        if (!$doc->loadHTML($html)) {
            die('Cannot parse html:' . $html);
        }
        libxml_use_internal_errors($internalErrors);
        $links = $doc->getElementById('entry')->getElementsByTagName('a');
        $lastValidTxt = '';
        foreach ($links as $link) {
            $href = trim($link->getAttribute('href'));
            if (!$this->isEpisode($href)) continue;
            $txt = $link->nodeValue;
            if ($this->ambiguousTxt($txt) && $lastValidTxt !== '') {
                $txt = $lastValidTxt . '(' . $txt . ')';
            } else {
                $lastValidTxt = $txt;
            }
            if (!Episode::where('href', $href)->first()) {
                //new episode
                $newEpisode = Episode::create([
                    'tv_id' => $this->tv->id,
                    'href' => $href,
                    'txt' => $txt
                ]);
                dispatch((new newEpisodesMail($this->tv, $newEpisode))->onQueue('newEpisodesMail'));
            }
        }
        unset($doc, $links, $html);
    }

    private function isEpisode($href)
    {
        if (str_contains($href, 'cn163.net')) return false;
        return true;
    }

    private function ambiguousTxt($txt)
    {
        if (strlen($txt) <= 5 && !preg_match('/\d+集|E\d+/', $txt)) return true;
        return false;
    }
}

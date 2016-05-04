<?php

namespace App\Jobs;

use App\Episode;
use App\Tv;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Storage;

/**
 * Class getTvEpisodes
 * @package App\Jobs
 */
class getTvEpisodes extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $tv;
    protected $skipMails;

    /**
     * Create a new job instance.
     *
     * @param Tv $tv
     * @param bool $skipMails
     */
    public function __construct(Tv $tv, $skipMails = false)
    {
        $this->tv = $tv;
        $this->skipMails = $skipMails;
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
        $entry = $doc->getElementById('entry');
        $links = $entry->getElementsByTagName('a');
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
                $this->skipMails or dispatch((new newEpisodesMail($this->tv, $newEpisode))->onQueue('newEpisodesMail'));
            }
        }
        //save entry to storage
        $entry->removeChild($entry->getElementsByTagName('div')[0]);
        $file = 'tv/' . $this->tv->id . '.html';
        if (Storage::exists($file)) {
            Storage::delete($file);
        }
        Storage::put($file, $doc->saveHTML($entry));
        unset($doc, $links, $html, $entry);
    }

    /**
     * @param $href
     * @return bool
     */
    private function isEpisode($href)
    {
        if (str_contains($href, 'cn163.net')) return false;
        return true;
    }

    /**
     * @param $txt
     * @return bool
     */
    private function ambiguousTxt($txt)
    {
        if (strlen($txt) <= 5 || !preg_match('/\d+集|E\d+/', $txt)) return true;
        return false;
    }
}

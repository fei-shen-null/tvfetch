<?php

namespace App\Jobs;

use App\Episode;
use App\Tv;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class newEpisodesMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $tv, $episode;

    /**
     * Create a new job instance.
     *
     * @param Tv $tv
     * @param Episode $episode
     */
    public function __construct(Tv $tv, Episode $episode)
    {
        $this->tv = $tv;
        $this->episode = $episode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = $this->tv->subTv()->with('User')->get()->pluck('User')->pluck('email')->all();//all users sub this tv
        if (empty($emails)) {
            $this->delete();
            return;
        }
        Mail::send('emails.newEpisode', ['tv' => $this->tv, 'episode' => $this->episode], function ($m) use ($emails) {
            $m->from(env('MAIL_FROM'));
            $m->cc($emails)->subject('New episode from TvFetch');
        });
    }
}

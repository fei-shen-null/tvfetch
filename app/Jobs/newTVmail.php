<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class newTVmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('',[
            
        ],function($m){
            
        });
        
    }
}

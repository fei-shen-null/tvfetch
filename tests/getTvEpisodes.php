<?php

class getTvEpisodes extends TestCase
{
    public function testStorage()
    {
        $tv = \App\Tv::orderByRaw('RAND()')->first();
        (new \App\Jobs\getTvEpisodes($tv))->handle();
        $this->assertFileExists(storage_path('app/tv/' . $tv->id . '.html'));
    }

    public function testMail()
    {
        (new \App\Jobs\getTvEpisodes(\App\Tv::find(1629)))->handle();

    }

}

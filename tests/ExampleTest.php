<?php

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */

    public function testBasicExample()
    {
        $this->baseUrl = config('app.url');
        $this->visit('/')
            ->see('美剧订阅');
    }
}

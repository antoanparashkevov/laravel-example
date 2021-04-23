<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{


    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/'); //we start with Act

       $response->assertSeeText('Hello world');
    }

    public function  testContactPageIsWorkingCorrectly(){


        $response=$this->get('/contact');

        $response->assertSeeText('Contact page!');

    }
}

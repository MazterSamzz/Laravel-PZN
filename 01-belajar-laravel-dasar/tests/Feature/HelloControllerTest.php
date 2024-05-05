<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHellos(): void
    {
        $response = $this->get('/controller/hello/Eko')->assertSeeText('Halo Eko');
    }

    public function testRequest()
    {
        $this->get('/controller/hello/request', [
            "Accept" => "plain/text"
        ])->assertSeeText('/controller/hello/request')
            ->assertSeeText('http://localhost/controller/hello/request')
            ->assertSeeText('GET')
            ->assertSeeText('plain/text');
    }
}

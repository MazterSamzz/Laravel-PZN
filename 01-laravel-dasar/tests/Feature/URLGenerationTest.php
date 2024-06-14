<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class URLGenerationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testURLCurrent(): void
    {
        $this->get('/url/current?name=Ivan')->assertSeeText('url/current?name=Ivan');
    }

    public function testNamed(): void
    {
        $this->get('/redirect/named')->assertSeeText('/redirect/name/Ivan');
    }

    public function testAction(): void
    {
        $this->get('/url/action')->assertSeeText('/form');
    }
}

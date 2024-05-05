<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testView(): void
    {
        $response = $this->get('/hello');

        $response->assertSeeText('Hello Ivan');
    }

    public function testNested ()
    {
        $this->get('/hello-world')->assertSeeText('World Ivan');
    }

    public function testTemplate ()
    {
        $this->view('hello', ['name' => 'Ivan'])->assertSeeText('Hello Ivan');

        $this->view('hello.world', ['name' => 'Ivan'])->assertSeeText('World Ivan');
    }
}

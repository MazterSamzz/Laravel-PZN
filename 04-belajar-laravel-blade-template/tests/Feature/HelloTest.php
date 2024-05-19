<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloTest extends TestCase
{
    public function testHello(): void
    {
        $this->get('/hello')->assertSeeText('Ivan');
    }
    public function testWorld(): void
    {
        $this->get('/world')->assertSeeText('Ivan');
    }
    public function testHelloView(): void
    {
        $this->view('hello', ['name' => 'Ivan'])->assertSeeText('Ivan');
    }
    public function testWorldView(): void
    {
        $this->view('hello.world', ['name' => 'Ivan'])->assertSeeText('Ivan');
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeTest extends TestCase
{
    public function testInclude(): void
    {
        $this->view('include.include')
            ->assertSeeText('Programmer Zaman Now')
            ->assertSeeText('Selamat Datang di Website kami')
            ->assertSeeText('Selamat Datang di Web');

        $this->view('include.include', ['title' => 'Ivan'])
            ->assertSeeText('Ivan')
            ->assertSeeText('Selamat Datang di Website kami')
            ->assertSeeText('Selamat Datang di Web');
    }
}

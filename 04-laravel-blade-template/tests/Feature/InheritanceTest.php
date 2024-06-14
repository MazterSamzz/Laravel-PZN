<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InheritanceTest extends TestCase
{
    public function testInheritance(): void
    {
        $this->view('template-inheritance.child', [])
            ->assertSeeText('Nama Aplikasi - Halaman Utama')
            ->assertSeeText('Default Header')
            ->assertSeeText('Deskripsi Header')
            ->assertDontSeeText('Default Content')
            ->assertSeeText('Ini adalah halaman utama');
    }

    public function testInheritanceWithoutOverride(): void
    {
        $this->view('template-inheritance.child-default')
            ->assertSeeText('Nama Aplikasi - Halaman Utama')
            ->assertSeeText('Default Header')
            ->assertSee('Default Content')
            ->assertDontSeeText('Deskripsi Header')
            ->assertDontSeeText('Ini adalah halaman utama');
    }
}

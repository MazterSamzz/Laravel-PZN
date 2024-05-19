<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeConditionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIncludeCondition(): void
    {
        $this->view('include-condition.include-condition', [
            'user' => [
                'name' => 'Ivan',
                'owner' => true
            ]
        ])->assertSeeText('Selamat Datang Owner')
            ->assertSeeText('Selamat Datang Ivan')
            ->assertDontSeeText('Semangat Bekerja');

        $this->view('include-condition.include-condition', [
            'user' => [
                'name' => 'Ivan',
                'owner' => false
            ]
        ])->assertDontSeeText('Selamat Datang Owner')
            ->assertSeeText('Selamat Datang Ivan')
            ->assertSeeText('Semangat Bekerja');
    }
}

<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateCookie(): void
    {
        $this->get('/cookie/set')
            ->assertSeeText('Hello Cookie')
            ->assertCookie('User-id', 'MazterSamzz')
            ->assertCookie('Is-Member', 'true');
    }

    public function testGetCookie(): void
    {
        $this->withCookie('User-id', 'MazterSamzz')
            ->withCookie('Is-Member', 'true')
            ->get('cookie/get')->assertJson([
                'User-id' => 'MazterSamzz',
                'Is-Member' => 'true'
            ]);
    }

    
}

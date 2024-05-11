<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateSession(): void
    {
        $this->get('/session/create')->assertSeeText('OK')
            ->assertSessionHas('userId', 'MazterSamzz')
            ->assertSessionHas('isMember', true);
    }

    public function testGetSession(): void
    {
        $this->withSession([
            'userId' => 'MazterSamzz',
            'isMember' => 'true'
        ])->get('/session/get')
            ->assertSeeText('User ID: MazterSamzz, Is Member: true');
    }
    public function testGetSessionFailed(): void
    {
        $this->get('/session/get')
            ->assertSeeText('User ID: guest, Is Member: false');
    }
}

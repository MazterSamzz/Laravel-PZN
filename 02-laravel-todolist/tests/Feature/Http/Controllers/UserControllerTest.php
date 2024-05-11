<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testloginPage(): void
    {
        $this->get('/login')->assertSeeText('Login');
    }

    public function testLoginForMember(): void
    {
        $this->withSession(['user' => 'Ivan'])->get('/login')->assertRedirect('/');
    }

    public function testLoginForUserAlreadyLogin(): void
    {
        $this->withSession(['user', 'Ivan'])->post('/login', ['user' => 'Ivan', 'password' => 'rahasia'])
            ->assertRedirect('/')
            ->assertSessionHas('user', 'Ivan');
    }

    public function testLoginSuccess(): void
    {
        $this->post('/login', [
            'user' => 'Ivan',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'Ivan');
    }

    public function testLoginValidationError(): void
    {
        $this->post('/login', [
            'user' => '',
            'password' => ''
        ])->assertSeeText('Input user or password required');
    }

    public function testLoginFailed(): void
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText('User or password didn\'t match');
    }

    public function testLogout(): void
    {
        $this->post('/logout')->assertRedirect('/')
            ->assertSessionMissing('user');
    }

    public function testLogoutGuest(): void
    {
        $this->post('/logout')->assertRedirect('/');
    }
}

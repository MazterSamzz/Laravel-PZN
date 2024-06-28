<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testAuth(): void
    {
        $this->seed(UserSeeder::class);

        $success = Auth::attempt([
            "email" => "ivan@localhost",
            "password" => "rahasia"
        ], true);
        self::assertTrue($success);

        $user = Auth::user();
        echo $user;
        self::assertNotNull($user);
        self::assertEquals("Ivan Kristyanto", $user->name);
        self::assertEquals("ivan@localhost", $user->email);
    }

    public function testGuest(): void
    {
        $user = Auth::user();
        self::assertNull($user);
    }
}

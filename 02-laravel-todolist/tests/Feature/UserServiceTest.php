<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess(): void
    {
        self::assertTrue(
            $this->userService->login('Ivan', 'rahasia')
        );
    }

    public function testLoginUserNotFound(): void
    {
        self::assertFalse($this->userService->login('Kris', 'rahasia'));
    }

    public function testLoginWrongPassword(): void
    {
        self::assertFalse($this->userService->login('Ivan', 'salah'));
    }
}

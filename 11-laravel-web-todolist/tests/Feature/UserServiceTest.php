<?php

namespace Tests\Feature;

use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
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

        DB::delete('delete from users');
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess(): void
    {
        $this->seed([UserSeeder::class]);
        self::assertTrue(
            $this->userService->login('MazterSamzz@gmail.com', 'rahasia')
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

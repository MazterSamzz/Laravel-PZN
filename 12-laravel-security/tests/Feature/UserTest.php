<?php

namespace Tests\Feature;

use App\Models\User;
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

    public function testLogin(): void
    {
        $this->seed(UserSeeder::class);

        $response = $this->get("/users/login?email=ivan@localhost&password=rahasia")
            ->assertRedirect("/users/current");
        $response = $this->get("/users/login?email=salah&password=rahasia")
            ->assertSeeText("Wrong Credentials");
    }

    public function testCurrent(): void
    {
        $this->seed(UserSeeder::class);
        $response = $this->get("/users/current")
            ->assertStatus(302)
            ->assertRedirect("/login");

        $user = User::where("email", "ivan@localhost")->firstOrFail();
        $this->actingAs($user)
            ->get("/users/current")
            ->assertSeeText("Hello Ivan Kristyanto");
    }
}

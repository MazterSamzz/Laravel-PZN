<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HashTest extends TestCase
{
    public function testHash(): void
    {
        $password = "rahasia";
        $hash = Hash::make($password);

        $password2 = "rahasia";
        $hash2 = Hash::make($password2);

        self::assertNotEquals($hash, $hash2);

        $result = Hash::check("rahasia", $hash);
        self::assertTrue($result);
    }
}

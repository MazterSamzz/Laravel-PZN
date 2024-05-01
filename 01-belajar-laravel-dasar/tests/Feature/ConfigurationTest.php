<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig(){
        $firstName = config('contoh.author.first');
        $lastName = config('contoh.author.last');
        $email = config('contoh.email');
        $web = config('contoh.web');

        self::assertEquals('Ivan', $firstName);
        self::assertEquals('Kristyanto', $lastName);
        self::assertEquals('maztersamzz@gmail.com', $email);
        self::assertEquals('https://www.maztersamzz.com', $web);
    }
}

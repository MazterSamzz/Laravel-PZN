<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class InlineTest extends TestCase
{
    public function testInline(): void
    {
        $response = Blade::render('Hello {{ $name }}', ['name' => 'Ivan']);
        self::assertEquals('Hello Ivan', $response);
    }
}

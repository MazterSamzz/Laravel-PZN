<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WhileTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->view('while', ['i' => 0])
            ->assertSeeText('The Current Value is 0')
            ->assertSeeText('The Current Value is 1')
            ->assertSeeText('The Current Value is 2')
            ->assertSeeText('The Current Value is 3')
            ->assertSeeText('The Current Value is 4')
            ->assertSeeText('The Current Value is 5')
            ->assertSeeText('The Current Value is 6')
            ->assertSeeText('The Current Value is 7')
            ->assertSeeText('The Current Value is 8')
            ->assertSeeText('The Current Value is 9');
    }
}

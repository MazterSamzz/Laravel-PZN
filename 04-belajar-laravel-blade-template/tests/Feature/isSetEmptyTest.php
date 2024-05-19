<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class isSetEmptyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIsSetAndEmpty(): void
    {
        $this->view('isset-empty', [])
            ->assertDontSeeText('Hello')
            ->assertSeeText("I don't have any hobbies", false);

        $this->view('isset-empty', ['name' => 'Ivan'])
            ->assertSeeText('Hello, my name is Ivan');

        $this->view('isset-empty', ['name' => 'Ivan', 'hobbies' => ['Coding']])
            ->assertSeeText('Hello, my name is Ivan')
            ->assertDontSeeText("I don't have any hobbies", false);
    }
}

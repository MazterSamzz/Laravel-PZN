<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->view('form', ['user' => [
            'premium' => true,
            'name' => "Ivan",
            'admin' => true
        ]])->assertSee('checked')
            ->assertSee('Ivan')
            ->assertDontSee('readonly');

        $this->view('form', ['user' => [
            'premium' => false,
            'name' => "Ivan",
            'admin' => false
        ]])->assertDontSee('checked')
            ->assertSee('Ivan')
            ->assertSee('readonly');
    }
}

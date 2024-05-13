<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testTodoList(): void
    {
        $this->withSession([
            'user' => 'MazterSamzz',
            'todoList' => [
                [
                    'id' => '1',
                    'todo' => 'Eko'
                ],
                [
                    'id' => '2',
                    'todo' => 'Joko'
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText('1')->assertSeeText('Eko')
            ->assertSeeText('2')->assertSeeText('Joko');
    }
}

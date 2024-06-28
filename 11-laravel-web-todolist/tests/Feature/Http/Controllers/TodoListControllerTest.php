<?php

namespace Tests\Feature\Http\Controllers;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from todos');
    }

    /**
     * A basic feature test example.
     */
    public function testTodoList(): void
    {
        $this->seed(TodoSeeder::class);

        $this->withSession([
            'user' => 'MazterSamzz'
        ])->get('/todolist')
            ->assertSeeText('1')->assertSeeText('Ivan')
            ->assertSeeText('2')->assertSeeText('Kristyanto');
    }

    public function testAddTodoFailed(): void
    {
        $this->withSession([
            'user' => 'MazterSamzz'
        ])->post('/todolist')
            ->assertSeeText('Todo is required');
    }

    public function testAddTodoSuccess(): void
    {
        $this->withSession([
            'user' => 'MazterSamzz',
            'todoList' => [
                'id' => '1',
                'todo' => 'Eko'
            ]
        ])->post('/todolist', ['todo' => 'Iwan'])
            ->assertRedirect('/todolist');
    }

    public function testRemoveTodoList(): void
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
        ])->post('/todolist/1/delete')->assertRedirect('/todolist');
    }
}

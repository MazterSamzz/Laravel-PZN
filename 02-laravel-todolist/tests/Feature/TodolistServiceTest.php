<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;
    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListService(): void
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'Ivan');

        $todoList = Session::get('todoList');
        foreach ($todoList as $todo) {
            self::assertEquals('1', $todo['id']);
            self::assertEquals('Ivan', $todo['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoListNotEmpty()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'Eko'
            ],
            [
                'id' => '2',
                'todo' => 'Joko'
            ]
        ];

        $this->todoListService->saveTodo('1', 'Eko');
        $this->todoListService->saveTodo('2', 'Joko');

        self::assertEquals($expected, $this->todoListService->getTodoList());
    }
}

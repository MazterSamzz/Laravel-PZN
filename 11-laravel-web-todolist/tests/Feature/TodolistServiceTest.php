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

    public function testRemoveTodo(): void
    {
        $this->todoListService->saveTodo('1', 'Ivan');
        $this->todoListService->saveTodo('2', 'Lisa');
        $this->todoListService->saveTodo('3', 'Sky');
        self::assertEquals(3, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('1');
        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('4');
        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('2');
        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('3');
        self::assertEquals(0, sizeof($this->todoListService->getTodoList()));
    }
}

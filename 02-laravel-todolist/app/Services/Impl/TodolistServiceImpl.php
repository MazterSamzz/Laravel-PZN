<?php

namespace App\Services\Impl;

use App\Services\TodoListService;
use Illuminate\Support\Facades\Session;

class TodoListServiceImpl implements TodoListService
{
    /**
     * Saves a todo item to the session.
     *
     * @param string $id The ID of the todo item.
     * @param string $todo The content of the todo item.
     * @return void
     */
    public function saveTodo(string $id, string $todo): void
    {
        if (!Session::exists('todoList')) {
            Session::put('todoList', []);
        }

        Session::push('todoList', ['id' => $id, 'todo' => $todo]);
    }

    public function getTodoList(): array
    {
        return Session::get('todoList', []);
    }


    /**
     * Removes a todo item with the specified ID from the todo list.
     *
     * @param string $todoId The ID of the todo item to be removed.
     */
    public function removeTodo(string $todoId)
    {
        $todoList = Session::get('todoList', []);

        foreach ($todoList as $index => $todo) {
            if ($todo['id'] == $todoId) {
                unset($todoList[$index]);
                break;
            }
        }
        Session::put('todoList', $todoList);
    }
}

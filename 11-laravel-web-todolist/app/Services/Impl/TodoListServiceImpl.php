<?php

namespace App\Services\Impl;

use App\Models\Todo;
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
        $todo = new Todo([
            'id' => $id,
            'todo' => $todo
        ]);
        $todo->save();
    }

    public function getTodoList(): array
    {
        return Todo::get()->toArray();
    }


    /**
     * Removes a todo item with the specified ID from the todo list.
     *
     * @param string $todoId The ID of the todo item to be removed.
     */
    public function removeTodo(string $todoId)
    {
        $todo = Todo::find($todoId);

        if ($todo != null)
            $todo->delete();
    }
}

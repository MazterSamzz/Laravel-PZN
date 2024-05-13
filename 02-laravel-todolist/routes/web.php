<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

Route::view('/template', 'template');

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::middleware(App\Http\Middleware\OnlyGuestMiddleware::class)->group(function () {
        Route::get('/login', 'login');
        Route::post('/login', 'doLogin');
    });
    Route::post('/logout', 'logout')->middleware([App\Http\Middleware\OnlyMemberMiddleware::class]);
});

Route::controller(\App\Http\Controllers\TodoListController::class)
    ->middleware([App\Http\Middleware\OnlyMemberMiddleware::class])->group(function () {
        Route::get('/todolist', 'todoList');
        Route::post('/todolist', 'addTodo');
        Route::post('/todolist/{id}/delete', 'removeTodo');
    });

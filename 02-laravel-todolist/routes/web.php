<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/template', 'template');

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::middleware(App\Http\Middleware\OnlyGuestMiddleware::class)->group(function () {
        Route::get('/login', 'login');
        Route::post('/login', 'doLogin');
    });
    Route::post('/logout', 'logout')->middleware([App\Http\Middleware\OnlyMemberMiddleware::class]);
});

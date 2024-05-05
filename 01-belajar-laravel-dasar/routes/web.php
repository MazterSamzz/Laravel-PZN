<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pzn', function () {
    return "Hello Programmer Zaman Now";
});

Route::redirect('/youtube', '/pzn');

Route::fallback(function () {
    return "404 by Programmer Zaman Now";
});

Route::view('/hello', 'hello', ['name' => 'Ivan']);

Route::get('/hello-again', function () {
    return view('hello', ['name' => 'Ivan']);
});

Route::get('/hello-world', function () {
    return view('hello.world', ['name' => 'Ivan']);
});

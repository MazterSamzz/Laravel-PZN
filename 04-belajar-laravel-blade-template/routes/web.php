<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello', ['name' => 'Ivan']);
});

Route::get('/world', function () {
    return view('hello.world', ['name' => 'Ivan']);
});


Route::get('/html-encoding', function (\Illuminate\Http\Request $request) {
    return view('html-encoding', ['name' => $request->input('name')]);
});

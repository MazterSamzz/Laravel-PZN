<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/form/login', [App\Http\Controllers\FormController::class, 'login']);

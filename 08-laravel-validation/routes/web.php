<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/form/login', [App\Http\Controllers\FormController::class, 'login']);

Route::get('/form', [App\Http\Controllers\FormController::class, 'form']);
Route::post('/form', [App\Http\Controllers\FormController::class, 'submitForm']);

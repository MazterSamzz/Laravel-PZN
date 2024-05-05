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

Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
});

Route::get('/products/{id}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, Item $itemId";
});

Route::get('/categories/{id}', function($categoryId) {
    return "Category $categoryId";
})->where('id', '[0-9]+');

Route::get('/users/{id?}', function($userId = '404') {
    return "User $userId";
});

Route::get('/conflict/eko', function() {
    return "Conflict Eko Kurniawan Khannedy";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});

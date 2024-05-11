<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
})->name('product.detail');

Route::get('/products/{id}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, Item $itemId";
})->name('product.item.detail');

Route::get('/categories/{id}', function ($categoryId) {
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function ($userId = '404') {
    return "User $userId";
})->name('user.detail');

Route::get('/conflict/eko', function () {
    return "Conflict Eko Kurniawan Khannedy";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});

Route::get('/produk/{id}', function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('/produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});

Route::prefix('/controller/hello')->controller(App\Http\Controllers\HelloController::class)->group(function () {
    Route::get('/request', 'request');
    Route::get('/{name}', 'hello');
});

Route::prefix('/input/hello')->controller(App\Http\Controllers\InputController::class)->group(function () {
    Route::get('/', 'hello');
    Route::post('/', 'hello');
    Route::post('/first', 'helloFirstName');
    Route::post('/input', 'helloInput');
    Route::post('/array', 'helloArray');
});

Route::post('/input/type', [App\Http\Controllers\InputController::class, 'inputType']);

Route::prefix('/input/filter')->controller(App\Http\Controllers\InputController::class)->group(function () {
    Route::post('/only', 'filterOnly');
    Route::post('/except', 'filterExcept');
    Route::post('/merge', 'filterMerge');
});

Route::post('/file/upload', [App\Http\Controllers\FileController::class, 'upload']);

Route::prefix('/response')->controller(App\Http\Controllers\ResponseController::class)->group(function () {
    Route::get('/hello', 'response');
    Route::get('/header', 'header');
});

Route::prefix('response/type')->controller(App\Http\Controllers\ResponseController::class)->group(function () {
    Route::get('/view', 'responseView');
    Route::get('/json', 'responseJson');
    Route::get('/file', 'responseFile');
    Route::get('/download', 'responseDownload');
});

Route::prefix('/cookie')->controller(App\Http\Controllers\CookieController::class)->group(function () {
    Route::get('/set', 'createCookie');
    Route::get('/get', 'getCookie');
    Route::get('/clear', 'clearCookie');
});

Route::prefix('/redirect')->controller(App\Http\Controllers\RedirectController::class)->group(function () {
    Route::get('/from', 'redirectFrom');
    Route::get('/to', 'redirectTo');
    Route::get('/name', 'redirectName');
    Route::get('/name/{name}', 'redirectHello')->name('redirect-hello');
    Route::get('/named', function () {
        // return route('redirect-hello', ['name' => 'Ivan']);
        // return url()->route('redirect-hello', ['name' => 'Ivan']);
        return URL::route('redirect-hello', ['name' => 'Ivan']);
    });
    Route::get('/action', 'redirectAction');
    Route::get('/away', 'redirectAway');
});

Route::middleware(['contoh:PZN,401'])->group(function () {
    Route::get('/middleware/api', function () {
        return 'OK';
    });
    Route::get('middleware/group', function () {
        return 'OK';
    });
});

Route::prefix('/form')->controller(App\Http\Controllers\FormController::class)->group(function () {
    Route::get('/', 'form');
    Route::post('/', 'submitForm');
});

Route::prefix('/url')->group(function () {
    Route::get('/current', function () {
        return URL::full();
    });
    Route::get('/action', function () {
        // return action([App\Http\Controllers\FormController::class, 'form'], []);
        // return url()->action([App\Http\Controllers\FormController::class, 'form'], []);
        return URL::action([App\Http\Controllers\FormController::class, 'form'] . []);
    });
});

Route::prefix('/session')->controller('App\Http\Controllers\SessionController')->group(function () {
    Route::get('/create', 'createSession');
    Route::get('/get', 'getSession');
});

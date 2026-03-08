<?php

use App\Http\Controllers\Web\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hlow', function () {
    return view('hlow');
});

Route::get('/even-numbers', function () {
    return view('even-numbers');
});

Route::get('/prime-numbers', function () {
    return view('prime-numbers');
});

Route::get('/odd-numbers', function () {
    return view('odd-numbers');
});

Route::get('/square-numbers', function () {
    return view('square-numbers');
});

Route::get('/b', function () {
    $records = [1, 2, 3];

    return view('b', compact('records'));
});

Route::get('/multiplication/{number?}', function (Request $request, ?int $number = null) {
    $requestedNumber = $request->integer('number');
    $j = $requestedNumber > 0 ? $requestedNumber : ($number && $number > 0 ? $number : 2);

    return view('multiplication', compact('j'));
});

Route::get('/products', [ProductsController::class, 'list'])->name('products_list');
Route::get('/products/show/{product}', [ProductsController::class, 'show'])->name('products_show');
Route::get('/products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('/products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('/products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

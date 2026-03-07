<?php

use App\Http\Controllers\Web\ProductsController;
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
    // Test records variable.
    $records = [1, 2, 3];

    // Helper function to check prime numbers.
    function isPrime($num)
    {
        if ($num < 2) {
            return false;
        }

        if ($num == 2) {
            return true;
        }

        if ($num % 2 == 0) {
            return false;
        }

        for ($i = 3; $i <= sqrt($num); $i += 2) {
            if ($num % $i == 0) {
                return false;
            }
        }

        return true;
    }

    return view('b', compact('records'));
});

Route::get('/multiplication/{number?}', function ($number = null) {
    $j = $number ?? 2;

    return view('multiplication', compact('j'));
});

Route::get('/products', [ProductsController::class, 'list'])->name('products_list');
Route::get('/products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('/products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('/products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

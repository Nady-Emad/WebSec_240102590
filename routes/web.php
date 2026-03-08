<?php

use App\Http\Controllers\Web\ExamController;
use App\Http\Controllers\Web\GradeController;
use App\Http\Controllers\Web\Lab2Controller;
use App\Http\Controllers\Web\Lab3AuthController;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\QuestionController;
use App\Http\Controllers\Web\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::prefix('lab1')->name('lab1.')->group(function () {
    Route::view('/hlow', 'hlow')->name('status');
    Route::view('/even-numbers', 'even-numbers')->name('even');
    Route::view('/odd-numbers', 'odd-numbers')->name('odd');
    Route::view('/prime-numbers', 'prime-numbers')->name('prime');
    Route::view('/square-numbers', 'square-numbers')->name('square');

    Route::get('/b', function () {
        $records = [1, 2, 3];

        return view('b', compact('records'));
    })->name('records');

    Route::get('/multiplication/{number?}', function (Request $request, ?int $number = null) {
        $requestedNumber = $request->integer('number');
        $j = $requestedNumber > 0 ? $requestedNumber : ($number && $number > 0 ? $number : 2);

        return view('multiplication', compact('j'));
    })->name('multiplication');

    Route::prefix('products')->name('products.')->controller(ProductsController::class)->group(function () {
        Route::get('/', 'list')->name('index');
        Route::get('/show/{product}', 'show')->name('show');
        Route::get('/edit/{product?}', 'edit')->name('edit');
        Route::post('/save/{product?}', 'save')->name('save');
        Route::delete('/{product}', 'delete')->name('destroy');
    });
});

Route::prefix('lab2')->name('lab2.')->controller(Lab2Controller::class)->group(function () {
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', 'products')->name('index');
        Route::post('/{product}/add-to-cart', 'addToCart')->name('add_to_cart');
        Route::post('/{product}/remove-from-cart', 'removeFromCart')->name('remove_from_cart');
        Route::post('/clear-cart', 'clearCart')->name('clear_cart');
    });

    Route::middleware('lab3.auth')->group(function () {
        Route::get('/transcript', 'transcript')->name('transcript');
        Route::get('/gpa-simulator', 'gpaSimulator')->name('gpa_simulator');
    });

    Route::get('/calculator', 'calculator')->name('calculator');
});

Route::prefix('lab3')->name('lab3.')->group(function () {
    Route::controller(Lab3AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->middleware('throttle:5,1')->name('login.submit');
        Route::post('/logout', 'logout')->name('logout');
    });

    Route::middleware('lab3.auth')->group(function () {
        Route::middleware('lab3.role:admin')->group(function () {
            Route::resource('users', UserManagementController::class)->except(['show']);
        });

        Route::middleware('lab3.role:admin,instructor')->group(function () {
            Route::resource('grades', GradeController::class)->except(['show']);
            Route::resource('questions', QuestionController::class)->except(['show']);
        });

        Route::middleware('lab3.role:admin,instructor,student')
            ->controller(ExamController::class)
            ->prefix('exam')
            ->name('exam.')
            ->group(function () {
                Route::get('/start', 'start')->name('start');
                Route::post('/submit', 'submit')->name('submit');
            });
    });
});

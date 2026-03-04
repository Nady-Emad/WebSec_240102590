<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hlow', function () {
    return view('hlow');
});

Route::get('/multiplication', function () {
    $j = 5;

    return view('multiplication', compact('j'));
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
    return view('b');
});

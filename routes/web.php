<?php

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
    // تعريف متغير records للاختبار
    $records = [1, 2, 3]; // يمكن تغييره حسب الحاجة
    
    // دالة للتحقق من الأعداد الأولية
    function isPrime($num) {
        if ($num < 2) return false;
        if ($num == 2) return true;
        if ($num % 2 == 0) return false;
        for ($i = 3; $i <= sqrt($num); $i += 2) {
            if ($num % $i == 0) return false;
        }
        return true;
    }
    
    return view('b', compact('records'));
});

Route::get('/multiplication/{number?}', function ($number = null) {
    $j = $number??2;
    return view('multiplication', compact('j')); //multable.blade.php
});

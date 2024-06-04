<?php

use Illuminate\Support\Facades\Route;

// Auth::routes(['verify' => true]);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
<?php

use Illuminate\Support\Facades\Route;

// This tells Laravel: "Match ANY path (.*) and just return the welcome view."
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

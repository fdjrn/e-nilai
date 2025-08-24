<?php

use Illuminate\Support\Facades\Route;

Route::name('home')->get('/', function () {
    return view('welcome');
});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/inbox', function () {
    return view('inbox');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
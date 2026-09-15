<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [AboutController::class, 'index']);
Route::get('/post', [PostController::class, 'index']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('authors', [\App\Http\Controllers\UserController::class, 'store'])->name('authors.store');
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::post('author', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('author.login');
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
});

Route::middleware('auth:api')->group(function () {
    Route::resource('authors', \App\Http\Controllers\UserController::class)->except('store');
    Route::resource('books', \App\Http\Controllers\BookController::class);
});

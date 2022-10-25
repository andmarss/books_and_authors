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
Route::resource('authors', \App\Http\Controllers\UserController::class)->except('store');
Route::resource('books', \App\Http\Controllers\BookController::class);
Route::get('categories', function () {
    return \App\Http\Resources\BookCategoryCleanResource::collection(\App\Models\BookCategory::all());
})->name('categories.index');

Route::middleware('guest')->group(function () {
    Route::post('authors', [\App\Http\Controllers\UserController::class, 'store'])->name('authors.store');
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::post('author', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('author.login');
    Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
});

Route::middleware('auth:api')->group(function () {
    Route::get('user', function (Request $request) {
        $user = $request->user();

        return (new \App\Http\Resources\UserResource($user))->response($request);
    })->name('user');
});

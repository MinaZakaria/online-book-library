<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

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

Route::controller(UserController::class)->group(function () {
    Route::post('auth', 'authenticate');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');
});

Route::middleware(['auth:api'])->controller(BookController::class)->group(function () {
    Route::post('/categories/{categoryId}/books', 'store');
});

Route::middleware(['auth:api'])->controller(CategoryController::class)->group(function () {
    Route::post('/categories/{categoryId}/add-to-fav', 'addToFavourite');
    Route::post('/categories/{categoryId}/remove-from-fav', 'removeFromFavourite');
});

Route::middleware(['auth:api'])->controller(BookController::class)->group(function () {
    Route::post('/books/{bookId}/borrow', 'borrow');
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthCheck;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("/albums")
->middleware(AuthCheck::class)
->name('albums.')
->group(function () {
    Route::get('/', [AlbumController::class, 'index'])->name('index');
});

Route::prefix("/album")
->middleware(AuthCheck::class)
->name('album.')
->group(function () {
    Route::delete('/delete', [AlbumController::class, 'delete'])->name('delete');
    Route::post('/vote', [AlbumController::class, 'vote'])->name('vote');
});

//Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
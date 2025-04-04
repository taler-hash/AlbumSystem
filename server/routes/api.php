<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\CorsMiddleware;

Route::middleware([CorsMiddleware::class, AuthCheck::class])
->group(function() {
    Route::prefix("/albums")
    ->name('albums.')
    ->group(function () {
        Route::get('/', [AlbumController::class, 'index'])->name('index');
    });

    Route::prefix("/album")
    ->name('album.')
    ->group(function () {
        Route::delete('/delete', [AlbumController::class, 'delete'])->name('delete');
        Route::post('/vote', [AlbumController::class, 'vote'])->name('vote');
    });

    Route::get('/getuserdetails', [AuthController::class, 'getUserDetails']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');


// Test if server is working
Route::get('/hello',function() {
    return view('app');
});
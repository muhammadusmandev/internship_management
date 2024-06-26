<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('guest')->prefix('auth')->group( function () {
    Route::post('register', 'AuthController@register')->name('register');
    Route::post('login', 'AuthController@login')->name('login');
    Route::delete('logout', 'AuthController@logout')->name('logout');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::prefix('auth')->group( function () {
        Route::delete('logout', 'AuthController@logout')->name('logout');
    });
});

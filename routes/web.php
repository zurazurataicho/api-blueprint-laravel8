<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// For accessing users
Route::prefix('')->name(RouteServiceProvider::ROUTE_NAME_USER)->group(function () {
    // Login a user
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [UserController::class, 'index']);
        Route::get('/logout', [UserController::class, 'logout']);
    });
});

// For accessing admins
Route::prefix('admin')->name(RouteServiceProvider::ROUTE_NAME_ADMIN)->group(function () {
    // Login an administrator
    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AdminController::class, 'index']);
        Route::get('/logout', [AdminController::class, 'logout']);
    });
});

<?php

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
    Route::post('/login', 'App\Http\Controllers\Api\UserController@login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', 'App\Http\Controllers\Api\UserController@index');
        Route::get('/logout', 'App\Http\Controllers\Api\UserController@logout');
    });
});

// For accessing admins
Route::prefix('admin')->name(RouteServiceProvider::ROUTE_NAME_ADMIN)->group(function () {
    Route::post('/login', 'App\Http\Controllers\Api\AdminController@login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', 'App\Http\Controllers\Api\AdminController@index');
        Route::get('/logout', 'App\Http\Controllers\Api\AdminController@logout');
    });
});

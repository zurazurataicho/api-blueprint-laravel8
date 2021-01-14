<?php

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

Route::post('/login', 'App\Http\Controllers\Api\SpaAuthController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', 'App\Http\Controllers\Api\SpaAuthController@index');
    Route::get('/logout', 'App\Http\Controllers\Api\SpaAuthController@logout');
});

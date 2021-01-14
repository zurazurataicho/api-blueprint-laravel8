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

Route::post('/issue', 'App\Http\Controllers\Api\ApiTokenController@issue');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', 'App\Http\Controllers\Api\ApiTokenController@index');
    Route::get('/revoke', 'App\Http\Controllers\Api\ApiTokenController@revoke');
});
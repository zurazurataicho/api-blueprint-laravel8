<?php

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Api\ApplicationController;
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

Route::prefix('')->name(RouteServiceProvider::ROUTE_NAME_API)->group(function () {
    // Issue an API access token
    Route::post('/issue', [ApplicationController::class, 'issue']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [ApplicationController::class, 'index']);
        Route::get('/revoke', [ApplicationController::class, 'revoke']);
    });
});

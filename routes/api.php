<?php

use App\Http\Controllers\User;
use App\Http\Controllers\Backoffice;
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
Route::post('/register', [User\Auth\RegisterController::class, 'register']);
Route::post('/login', [User\Auth\LoginController::class, 'login']);

Route::middleware('auth:api-backoffice')->group(function () {
    Route::post('/assign-promotion', [User\UserPromotionController::class, 'store']);
});

Route::prefix('/backoffice')->group(function () {

    Route::post('/login', [Backoffice\Auth\LoginController::class, 'login']);

    Route::middleware('auth:api-backoffice')->group(function () {
        Route::apiResource('promotion-codes', Backoffice\PromotionCodesController::class)->only('index', 'show', 'store');
    });
});
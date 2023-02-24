<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
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

Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'me');
        Route::post('reset_password', 'reset_password');
    });
});

Route::middleware('auth:sanctum')->apiResource('poll', PollController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('poll/{poll_id}/vote/{choice_id}', [PollController::class, 'vote']);
});

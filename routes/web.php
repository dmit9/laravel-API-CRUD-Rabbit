<?php

use App\Http\Controllers\Api\V1\PositionController;
use App\Http\Controllers\Api\V1\TokenController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Middleware\SuccessMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');;
Route::get('web/users/{user}', [App\Http\Controllers\IndexController::class, 'show'])->name('web.users.show');
Route::post('web/users', [App\Http\Controllers\IndexController::class, 'store'])->name('web.users.store');

Route::prefix('api/v1')->middleware(SuccessMiddleware::class)->group(function () {
    Route::post('/users', [UserController::class, 'store'])->middleware('auth:sanctum');
    Route::apiResource('users', \App\Http\Controllers\Api\V1\UserController::class);
    Route::get('positions', [PositionController::class, 'index']);
    Route::get('/token', [TokenController::class, 'generateToken']);
});

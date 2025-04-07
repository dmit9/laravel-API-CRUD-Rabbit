<?php

use App\Http\Controllers\Api\V1\PositionController;
use App\Http\Controllers\Api\V1\TokenController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Middleware\SuccessMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RabbitController;


Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');
Route::get('/rabbit', [App\Http\Controllers\IndexController::class, 'rabbit'])->name('rabbit');
Route::patch('/rabbit', [RabbitController::class, 'update'])->name('rabbit.update');

Route::group(['prefix' => 'user'], function () {
    Route::get('/{user}', [App\Http\Controllers\IndexController::class, 'show'])->name('user.show');
    Route::post('/', [App\Http\Controllers\IndexController::class, 'store'])->name('user.store');
    Route::get('/{user}/edit', [App\Http\Controllers\IndexController::class, 'edit'])->name('user.edit');
    Route::patch('/{user}', [App\Http\Controllers\IndexController::class, 'update'])->name('user.update');
    Route::get('/create', [App\Http\Controllers\IndexController::class, 'create'])->name('user.create');
    Route::delete('/{user}', [App\Http\Controllers\IndexController::class , 'delete'])->name('user.delete');
});

Route::prefix('api/v1')->group(function () {
    Route::post('/users', [UserController::class, 'store'])->middleware('auth:sanctum');
    Route::apiResource('users', UserController::class);
    Route::get('positions', [PositionController::class, 'index']);
    Route::get('/token', [TokenController::class, 'generateToken']);
});

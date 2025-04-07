<?php

use App\Http\Controllers\Api\V1\PositionController;
use App\Http\Controllers\Api\V1\TokenController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Middleware\SuccessMiddleware;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
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
=======

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');;
Route::get('web/users/{user}', [App\Http\Controllers\IndexController::class, 'show'])->name('web.users.show');
Route::post('web/users', [App\Http\Controllers\IndexController::class, 'store'])->name('web.users.store');

Route::prefix('api/v1')->middleware(SuccessMiddleware::class)->group(function () {
    Route::post('/users', [UserController::class, 'store'])->middleware('auth:sanctum');
    Route::apiResource('users', \App\Http\Controllers\Api\V1\UserController::class);
>>>>>>> 32571635c3cf78df90e016052fa98bb7d2cef48a
    Route::get('positions', [PositionController::class, 'index']);
    Route::get('/token', [TokenController::class, 'generateToken']);
});

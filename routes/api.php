<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Route::prefix('v1')->group(function () {
//    Route::middleware(SuccessMiddleware::class)->group(function () {
//        Route::apiResource('users', \Api\Http\Controllers\UserController::class);
//        Route::get('positions', [PositionController::class, 'index']);
//    });
//});

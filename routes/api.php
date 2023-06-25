<?php

use App\Http\Controllers\AuthController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index']);
    Route::get('/posts/my', [\App\Http\Controllers\PostController::class, 'my']);
    Route::get('/posts/recent', [\App\Http\Controllers\PostController::class, 'recent']);
    Route::get('/posts/{post}', [\App\Http\Controllers\PostController::class, 'show']);
    Route::post('/posts', [\App\Http\Controllers\PostController::class, 'create']);
    Route::put('/posts/{post}', [\App\Http\Controllers\PostController::class, 'update']);
    Route::delete('/posts/{post}', [\App\Http\Controllers\PostController::class, 'destroy']);


    Route::middleware(\App\Http\Middleware\CheckModeratorMiddleware::class)->post('/posts/{post}/block',
        [\App\Http\Controllers\PostController::class, 'block']);

});



<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Task\TaskController;
use App\Http\Controllers\Api\v1\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
    });
})->name('auth.');

Route::middleware('auth:api')->group(function () {
    Route::patch('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.status');
    Route::get('users/select', [UserController::class, 'select'])->name('users.select');
    Route::apiResource('users', UserController::class);


    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::patch('tasks/{task}/priority', [TaskController::class, 'updatePriority'])->name('tasks.priority');
    Route::apiResource('tasks', TaskController::class);
});





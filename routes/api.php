<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\V1\CompletedTaskController;
use App\Http\Controllers\Api\V1\TaskController;
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

/*
|--------------------------------------------------------------------------
| API Auth
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::post('logout', LogoutController::class)->middleware('auth:sanctum');
});

/*
|--------------------------------------------------------------------------
| API Tasks
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);
    Route::patch(
        '/tasks/{task}/complete',
        CompletedTaskController::class
    );
});

/*
|--------------------------------------------------------------------------
| API Users
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

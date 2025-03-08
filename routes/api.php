<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\TimeSheetApiController;
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

// Auth Routes
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    Route::post('projects-attach', [ProjectApiController::class, 'attachProjects']);
    Route::post('projects-detach', [ProjectApiController::class, 'detachProjects']);
    Route::get('get-user-projects', [ProjectApiController::class, 'getUserProjects']);
    Route::apiResource('projects', ProjectApiController::class);
    Route::apiResource('time-sheets', TimeSheetApiController::class)->shallow();
});

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\MyCourseController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses/{course}/buy', [CourseController::class, 'buy']);
    Route::get('/my-courses', [MyCourseController::class, 'index']);
    Route::get('/my-courses/{course}/lessons', [MyCourseController::class, 'lessons']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'api/documentation');

Route::get("/test", [\App\Http\Controllers\UserController::class, 'index']);
Route::get("/test/{id}", [\App\Http\Controllers\UserController::class, 'show']);
Route::post("/test", [\App\Http\Controllers\UserController::class, 'store']);
Route::put("/test/{id}", [\App\Http\Controllers\UserController::class, 'update']);
Route::delete("/test/{id}", [\App\Http\Controllers\UserController::class, 'destroy']);

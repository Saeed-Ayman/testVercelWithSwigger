<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/api/documentation');

Route::get("/api/users", [\App\Http\Controllers\UserController::class, 'index']);
Route::get("/api/users/{id}", [\App\Http\Controllers\UserController::class, 'show']);
Route::post("/api/users", [\App\Http\Controllers\UserController::class, 'store']);
Route::put("/api/users/{id}", [\App\Http\Controllers\UserController::class, 'update']);
Route::delete("/api/users/{id}", [\App\Http\Controllers\UserController::class, 'destroy']);

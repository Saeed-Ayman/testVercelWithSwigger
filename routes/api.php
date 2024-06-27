<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/users", [\App\Http\Controllers\UserController::class, 'index']);
Route::get("/users/{id}", [\App\Http\Controllers\UserController::class, 'show']);
Route::post("/users", [\App\Http\Controllers\UserController::class, 'store']);
Route::put("/users/{id}", [\App\Http\Controllers\UserController::class, 'update']);
Route::delete("/users/{id}", [\App\Http\Controllers\UserController::class, 'destroy']);

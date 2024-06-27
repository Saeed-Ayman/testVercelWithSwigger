<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/test", [\App\Http\Controllers\UserController::class, 'index']);
Route::get("/test/{id}", [\App\Http\Controllers\UserController::class, 'show']);
Route::post("/test", [\App\Http\Controllers\UserController::class, 'store']);
Route::put("/test/{id}", [\App\Http\Controllers\UserController::class, 'update']);
Route::delete("/test/{id}", [\App\Http\Controllers\UserController::class, 'destroy']);

<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'api/documentation');

Route::get("/test", [\App\Http\Controllers\TestController::class, 'index']);
Route::get("/test/{id}", [\App\Http\Controllers\TestController::class, 'show']);
Route::post("/test", [\App\Http\Controllers\TestController::class, 'store']);
Route::put("/test/{id}", [\App\Http\Controllers\TestController::class, 'update']);
Route::delete("/test/{id}", [\App\Http\Controllers\TestController::class, 'destroy']);

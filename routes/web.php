<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'api/documentation');

Route::get("/test", [\App\Http\Controllers\TestController::class, 'index']);

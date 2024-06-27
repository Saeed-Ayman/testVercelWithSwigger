<?php

use Illuminate\Support\Facades\Route;

Route::get("/test", fn() => "test");

Route::redirect('/', 'api/documentation');

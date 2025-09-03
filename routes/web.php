<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\TestController::class, 'show']);

Route::get('/archi-api-tech-studio', [\App\Http\Controllers\ArchiApiTechStudioController::class, 'show']);

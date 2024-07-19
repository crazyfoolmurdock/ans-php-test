<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index']);
Route::get('/{name}', [IndexController::class, 'view']);
Route::post('/search', [IndexController::class, 'search']);

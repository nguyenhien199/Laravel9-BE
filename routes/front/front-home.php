<?php

use App\Http\Controllers\Front\HomeFrontController;
use Illuminate\Support\Facades\Route;

/**
 * For Front-Client - HOME Web routes:
 * prefix:     /
 * name as:    front.
 * middleware: web
 */

Route::get('/', [HomeFrontController::class, 'index'])
    ->name('index');

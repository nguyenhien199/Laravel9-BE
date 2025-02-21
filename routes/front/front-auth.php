<?php

use Illuminate\Support\Facades\Route;

/**
 * For Front-Client - AUTH Web routes:
 * prefix:     /
 * name as:    front.
 * middleware: web
 */

//Route::get('/login', [\App\Http\Controllers\Front\AuthController::class, 'login'])
//    ->name('login');
//Route::get('/logout', [\App\Http\Controllers\Front\AuthController::class, 'logout'])
//    ->name('logout');

Route::redirect('/login', '/', HTTP_MOVED_PERMANENTLY)
    ->name('login');
Route::redirect('/logout', '/', HTTP_MOVED_PERMANENTLY)
    ->name('logout');
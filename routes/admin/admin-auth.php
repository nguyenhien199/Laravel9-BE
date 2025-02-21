<?php

use App\Constants\AuthConst;
use Illuminate\Support\Facades\Route;

/**
 * For Admin-CMS - AUTH Web routes:
 * prefix:     admin/
 * name as:    admin.
 * middleware: admin
 */

//Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])
//    ->name('login')
//    ->withoutMiddleware(AuthConst::ADMIN_MIDDLEWARE_WITHOUT_AUTH);
//Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])
//    ->name('logout');

Route::redirect('/login', '/', HTTP_MOVED_PERMANENTLY)
    ->name('login');
Route::redirect('/logout', '/', HTTP_MOVED_PERMANENTLY)
    ->name('logout');

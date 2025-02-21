<?php

use App\Constants\AuthConst;
use App\Http\Controllers\Admin\HomeAdminController;
use Illuminate\Support\Facades\Route;

/**
 * For Admin-CMS - HOME Web routes:
 * prefix:     admin/
 * name as:    admin.
 * middleware: admin
 */

Route::group(['excluded_middleware' => AuthConst::AMW_WITHOUT_AUTH], function () {
    Route::get('/', [HomeAdminController::class, 'index'])
        ->name('index');
    Route::get('/dashboard', [HomeAdminController::class, 'dashboard'])
        ->name('dashboard');
    Route::get('/opcache', [HomeAdminController::class, 'opcache'])
        ->name('opcache');
});


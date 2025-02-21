<?php

use App\Constants\AuthConst;
use App\Http\Controllers\Api\Admin\AuthApiAdminController;
use Illuminate\Support\Facades\Route;

/**
 * For Admin-CMS - Auth API routes:
 * prefix:     api/admin/
 * name as:    api.admin.
 * middleware: api_admin
 */

Route::group(['excluded_middleware' => AuthConst::API_AMW_WITHOUT_AUTH], function () {
    Route::post('/login', [AuthApiAdminController::class, 'login'])
        ->name('login');
    Route::post('/refresh', [AuthApiAdminController::class, 'refresh'])
        ->name('refresh');
});

Route::post('/logout', [AuthApiAdminController::class, 'logout'])
    ->name('logout');

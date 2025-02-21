<?php

use App\Constants\AuthConst;
use App\Http\Controllers\Api\Admin\HomeApiAdminController;
use Illuminate\Support\Facades\Route;

/**
 * For Admin-CMS - HOME API routes:
 * prefix:     api/admin/
 * name as:    api.admin.
 * middleware: api_admin
 */

Route::group(['excluded_middleware' => AuthConst::API_AMW_WITHOUT_AUTH], function () {
    Route::get('/', [HomeApiAdminController::class, 'index'])
        ->name('index-get');
    Route::post('/', [HomeApiAdminController::class, 'index'])
        ->name('index-post');
});
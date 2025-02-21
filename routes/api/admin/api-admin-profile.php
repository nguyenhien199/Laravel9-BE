<?php

use App\Http\Controllers\Api\Admin\ProfileApiAdminController;
use Illuminate\Support\Facades\Route;

/**
 * For Admin-CMS - Auth Profile API routes:
 * prefix:     api/admin/profile/
 * name as:    api.admin.profile.
 * middleware: api_admin
 */

Route::group([
    'prefix' => 'profile',
    'as'     => 'profile.',
], function () {
    Route::get('/', [ProfileApiAdminController::class, 'info'])->name('info');
    Route::post('/', [ProfileApiAdminController::class, 'update'])->name('update');

    /**
     * prefix:  api/admin/profile/password/
     * name as: api.admin.profile.password.
     */
    Route::group([
        'prefix' => 'password',
        'as'     => 'password.'
    ], function () {
        Route::post('/', [ProfileApiAdminController::class, 'updatePassword'])->name('update');
    });
});

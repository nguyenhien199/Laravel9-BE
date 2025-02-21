<?php

use App\Http\Controllers\Api\Admin\UserApiAdminController;
use Illuminate\Support\Facades\Route;

/**
 * For Admin-CMS - User API routes:
 * prefix:     api/admin/user/
 * name as:    api.admin.user.
 * middleware: api_admin
 */

Route::group([
    'prefix' => 'user',
    'as'     => 'user.',
], function () {
    Route::get('/', [UserApiAdminController::class, 'paginate'])->name('paginate');
    Route::post('/', [UserApiAdminController::class, 'create'])->name('create');
    Route::get('/{userId}', [UserApiAdminController::class, 'read'])->name('read')
        ->where('userId', '[0-9]+');
    Route::put('/{userId}', [UserApiAdminController::class, 'update'])->name('update')
        ->where('userId', '[0-9]+');
    Route::delete('/{userId}', [UserApiAdminController::class, 'delete'])->name('delete')
        ->where('userId', '[0-9]+');

    // Verify.
    Route::post('/verify/{userId}', [UserApiAdminController::class, 'verify'])->name('verify')
        ->where('userId', '[0-9]+');

    // Quick Lock and Unlock.
    Route::post('/lock/{userId}', [UserApiAdminController::class, 'lock'])->name('lock')
        ->where('userId', '[0-9]+');
    Route::post('/unlock/{userId}', [UserApiAdminController::class, 'unlock'])->name('unlock')
        ->where('userId', '[0-9]+');

    // Change Password.
    Route::post('/password/{userId}', [UserApiAdminController::class, 'changePassword'])->name('change-password')
        ->where('userId', '[0-9]+');
});

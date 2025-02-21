<?php

use App\Http\Controllers\Api\Front\ProfileApiFrontController;
use Illuminate\Support\Facades\Route;

/**
 * For Front-App - Auth Profile API routes:
 * prefix:     api/front/profile/
 * name as:    api.front.profile.
 * middleware: api_front
 */

Route::group([
    'prefix' => 'profile',
    'as'     => 'profile.',
], function () {
    Route::get('/', [ProfileApiFrontController::class, 'info'])->name('info');
    Route::post('/', [ProfileApiFrontController::class, 'update'])->name('update');

    /**
     * prefix:  api/front/profile/password/
     * name as: api.front.profile.password.
     */
    Route::group([
        'prefix' => 'password',
        'as'     => 'password.'
    ], function () {
        Route::post('/', [ProfileApiFrontController::class, 'updatePassword'])->name('update');
    });
});

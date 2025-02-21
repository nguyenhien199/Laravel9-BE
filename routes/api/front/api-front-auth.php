<?php

use App\Constants\AuthConst;
use App\Http\Controllers\Api\Front\AuthApiFrontController;
use Illuminate\Support\Facades\Route;

/**
 * For Front-App - Auth API routes:
 * prefix:     api/front/
 * name as:    api.front.
 * middleware: api_front
 */

Route::group(['excluded_middleware' => AuthConst::API_FMW_WITHOUT_AUTH], function () {
    Route::post('/register', [AuthApiFrontController::class, 'register'])
        ->name('register');
    Route::post('/login', [AuthApiFrontController::class, 'login'])
        ->name('login');
    Route::post('/refresh', [AuthApiFrontController::class, 'refresh'])
        ->name('refresh');
});

Route::post('/logout', [AuthApiFrontController::class, 'logout'])
    ->name('logout');

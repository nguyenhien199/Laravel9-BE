<?php

use App\Constants\AuthConst;
use App\Http\Controllers\Api\Front\HomeApiFrontController;
use Illuminate\Support\Facades\Route;

/**
 * For Front-App - HOME API routes:
 * prefix:     api/front/
 * name as:    api.front.
 * middleware: api_front
 */

Route::group(['excluded_middleware' => AuthConst::API_FMW_WITHOUT_AUTH], function () {
    Route::get('/', [HomeApiFrontController::class, 'index'])
        ->name('index-get');
    Route::post('/', [HomeApiFrontController::class, 'index'])
        ->name('index-post');
});
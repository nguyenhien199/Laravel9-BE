<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Global Routes that are used between both Admin-CMS and Front-App API.
 */

/**
 * For Admin-CMS API routes:
 * prefix:     api/admin/
 * name as:    api.admin.
 * middleware: api_admin
 */
Route::group([
    'prefix'     => 'api/admin',
    'as'         => 'api.admin.',
    'middleware' => 'api_admin',
], function () {
    fn_include_route_files(__DIR__.'/api/admin/');
});

/**
 * For Front-App API routes:
 * prefix:     api/front/
 * name as:    api.front.
 * middleware: api_front
 */
Route::group([
    'prefix'     => 'api/front',
    'as'         => 'api.front.',
    'middleware' => 'api_front',
], function () {
    fn_include_route_files(__DIR__.'/api/front/');
});

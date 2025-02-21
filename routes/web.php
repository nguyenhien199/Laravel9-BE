<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/sitemap-generate', function () {
    Artisan::call('sitemap:generate');
    return 'Sitemap Created Successfully';
});

/**
 * Global Routes that are used between both Admin and Front web.
 */

/**
 * For Admin-CMS web routes:
 * prefix:     admin/
 * name as:    admin.
 * middleware: admin
 */
Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => 'admin',
], function () {
    fn_include_route_files(__DIR__.'/admin/');
});

/**
 * For Front-Client web routes:
 * prefix:     /
 * name as:    front.
 * middleware: web
 */
Route::group([
    'prefix'     => '',
    'as'         => 'front.',
    'middleware' => 'web'
], function () {
    fn_include_route_files(__DIR__.'/front/');
});

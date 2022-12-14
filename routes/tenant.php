<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 4/28/2018
 * Time: 7:01 PM
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here is where you can register 'tenant' routes for your application. These
| routes are loaded by 'miracuthbert/laravel-multi-tenancy' within a group which
| contains the "tenant" middleware group. Now create something great!
|
*/
Route::group([], function () {
    /**
     * Projects Main (Resource) Routes
     */
    Route::resource('/projects', 'ProjectController');

    /**
     * --------------------------------------------------------------------------
     * Dashboard
     * --------------------------------------------------------------------------
     *
     * All other tenant routes should go above this one
     */
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

});

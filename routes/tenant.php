<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 4/28/2018
 * Time: 7:01 PM
 */

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here is where you can register 'tenant' routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "tenant" middleware group. Now create something great!
|
*/
Route::group(['as' => 'tenant.'], function () {
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
    Route::get('/{company}', 'DashboardController@index')->name('dashboard');

    /**
     * Alternative tenant switch route
     *
     * Switch Tenant Route
     */
    // Route::get('/{company}', 'TenantSwitchController@switch')->name('switch');

    /**
     * --------------------------------------------------------------------------
     * Dashboard
     *
     * Alternative tenant dashboard route
     * --------------------------------------------------------------------------
     *
     * All other tenant routes should go above this one
     */
    // Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

});

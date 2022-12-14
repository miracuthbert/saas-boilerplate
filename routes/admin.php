<?php

use Illuminate\Support\Facades\Route;


/** 
 * Dashboard Route
 */
Route::get('dashboard', [\SAAS\Http\Admin\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');

/**
 * Users Group Routes
 */
Route::group(['prefix' => '/users', 'as' => 'users.'], function () {

    /**
     * User Impersonate Routes
     */
    Route::group(['prefix' => '/impersonate', 'as' => 'impersonate.'], function () {
        // index
        Route::get('/', [\SAAS\Http\Admin\Controllers\User\UserImpersonateController::class, 'index'])->name('index');

        // store
        Route::post('/', [\SAAS\Http\Admin\Controllers\User\UserImpersonateController::class, 'store'])->name('store');
    });


    /**
     * User Group Routes
     */
    Route::group(['prefix' => '/{user}'], function () {
        Route::resource('/roles', \SAAS\Http\Admin\Controllers\User\UserRoleController::class, [
            'except' => [
                'show',
                'edit',
            ]
        ]);
    });
});

/**
 * Permissions Group Routes
 */
Route::group(['prefix' => '/permissions', 'as' => 'permissions.'], function () {

    /**
     * Role Group Routes
     */
    Route::group(['prefix' => '/{permission}'], function () {

        // toggle status
        Route::put('/status', [\SAAS\Http\Admin\Controllers\User\PermissionStatusController::class, 'toggleStatus'])->name('toggleStatus');
    });
});

/**
 * Permissions Resource Routes
 */
Route::resource('/permissions', \SAAS\Http\Admin\Controllers\User\PermissionController::class);

/**
 * Roles Group Routes
 */
Route::group(['prefix' => '/roles', 'as' => 'roles.'], function () {

    /**
     * Role Group Routes
     */
    Route::group(['prefix' => '/{role}'], function () {

        // toggle status
        Route::put('/status', [\SAAS\Http\Admin\Controllers\User\RoleStatusController::class, 'toggleStatus'])->name('toggleStatus');

        // revoke users access
        Route::put('/revoke', [\SAAS\Http\Admin\Controllers\User\RoleUsersDisableController::class, 'revokeUsersAccess'])->name('revokeUsersAccess');

        /**
         * Permissions Resource Routes
         */
        Route::resource('/permissions', \SAAS\Http\Admin\Controllers\User\RolePermissionController::class, [
            'only' => [
                'index',
                'store',
                'destroy',
            ]
        ]);
    });
});

/**
 * Roles Resource Routes
 */
Route::resource('/roles', \SAAS\Http\Admin\Controllers\User\RoleController::class);

/**
 * Users Resource Routes
 */
Route::resource('/users', \SAAS\Http\Admin\Controllers\User\UserController::class);

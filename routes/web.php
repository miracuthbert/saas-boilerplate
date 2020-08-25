<?php

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

/**
 * Auth Routes
 */

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth\Controllers'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    /**
     * Activation Group Routes
     */
    Route::group(['prefix' => '/activation', 'middleware' => ['guest'], 'as' => 'activation.'], function () {

        // resend index
        Route::get('/resend', 'ActivationResendController@index')->name('resend');

        // resend store
        Route::post('/resend', 'ActivationResendController@store')->name('resend.store');

        // activation
        Route::get('/{confirmation_token}', 'ActivationController@activate')->name('activate');
    });

    /**
     * Two Factor Login Group Routes
     */
    Route::group(['prefix' => '/login/twofactor', 'middleware' => ['guest'], 'as' => 'login.twofactor.'], function () {

        // index
        Route::get('/', 'TwoFactorLoginController@index')->name('index');

        // store
        Route::post('/', 'TwoFactorLoginController@verify')->name('verify');
    });
});

/**
 * Home Routes
 */
Route::group(['namespace' => 'Home\Controllers'], function () {

    // index
    Route::get('/', 'HomeController@index')->name('home');
});

/**
 * Plans Routes
 */
Route::group(['namespace' => 'Subscription\Controllers'], function () {

    /**
     * Plans Group Routes
     */
    Route::group(['prefix' => '/plans', 'as' => 'plans.'], function () {

        // teams index
        Route::get('/teams', 'PlanTeamController@index')->name('teams.index');
    });

    /**
     * Plans Resource Routes
     */
    Route::resource('/plans', 'PlanController', [
        'only' => [
            'index',
            'show'
        ]
    ]);

    /**
     * Subscription Resource Routes
     */
    Route::resource('/subscription', 'SubscriptionController', [
        'only' => [
            'index',
            'store'
        ]
    ])->middleware(['auth.register', 'subscription.inactive']);
});

/**
 * Developer Routes.
 *
 * Handles developer routes.
 */
Route::group(['prefix' => '/developers', 'middleware' => ['auth'], 'namespace' => 'Developer\Controllers', 'as' => 'developer.'], function () {

    // index
    Route::get('/', 'DeveloperController@index')->name('index');
});

/**
 * Subscription: active Routes
 */
Route::group(['middleware' => ['subscription.active']], function () {
});

/**
 * Account Group Routes.
 *
 * Handles user's account routes.
 */
Route::group(['prefix' => '/account', 'middleware' => ['auth'], 'namespace' => 'Account\Controllers', 'as' => 'account.'], function () {

    /**
     * Dashboard
     */
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    /**
     * Companies Resource Routes
     */
    Route::resource('/companies', 'Company\CompanyController', [
        'only' => [
            'index',
            'create',
            'store'
        ]
    ]);

    /**
     * Account
     */
    // account index
    Route::get('/', 'AccountController@index')->name('index');

    /**
     * Profile
     */
    // profile index
    Route::get('/profile', 'ProfileController@index')->name('profile.index');

    // profile update
    Route::post('/profile', 'ProfileController@store')->name('profile.store');

    /**
     * Password
     */
    // password index
    Route::get('/password', 'PasswordController@index')->name('password.index');

    // password store
    Route::post('/password', 'PasswordController@store')->name('password.store');

    /**
     * Deactivate
     */
    // deactivate account index
    Route::get('/deactivate', 'DeactivateController@index')->name('deactivate.index');

    // deactivate store
    Route::post('/deactivate', 'DeactivateController@store')->name('deactivate.store');

    /**
     * Two factor
     */
    Route::group(['prefix' => '/twofactor', 'as' => 'twofactor.'], function () {
        // two factor index
        Route::get('/', 'TwoFactorController@index')->name('index');

        // two factor store
        Route::post('/', 'TwoFactorController@store')->name('store');

        // two factor verify
        Route::post('/verify', 'TwoFactorController@verify')->name('verify');

        // two factor verify
        Route::delete('/', 'TwoFactorController@destroy')->name('destroy');
    });

    /**
     * Tokens
     */
    Route::group(['prefix' => '/tokens', 'as' => 'tokens.'], function () {
        // personal access token index
        Route::get('/', 'PersonalAccessTokenController@index')->name('index');
    });

    /**
     * Subscription
     */
    Route::group(['prefix' => '/subscription', 'namespace' => 'Subscription',
        'middleware' => ['subscription.owner'], 'as' => 'subscription.'], function () {
        /**
         * Cancel
         *
         * Accessed if there is an active subscription.
         */
        Route::group(['prefix' => '/cancel', 'middleware' => ['subscription.notcancelled'], 'as' => 'cancel.'], function () {
            // cancel subscription index
            Route::get('/', 'SubscriptionCancelController@index')->name('index');

            // cancel subscription
            Route::post('/', 'SubscriptionCancelController@store')->name('store');
        });

        /**
         * Resume
         *
         * Accessed if subscription is cancelled but not expired.
         */
        Route::group(['prefix' => '/resume', 'middleware' => ['subscription.cancelled'], 'as' => 'resume.'], function () {
            // resume subscription index
            Route::get('/', 'SubscriptionResumeController@index')->name('index');

            // resume subscription
            Route::post('/', 'SubscriptionResumeController@store')->name('store');
        });

        /**
         * Swap Subscription
         *
         * Accessed if there is an active subscription.
         */
        Route::group(['prefix' => '/swap', 'middleware' => ['subscription.notcancelled'], 'as' => 'swap.'], function () {
            // swap subscription index
            Route::get('/', 'SubscriptionSwapController@index')->name('index');

            // swap subscription store
            Route::post('/', 'SubscriptionSwapController@store')->name('store');
        });

        /**
         * Card
         */
        Route::group(['prefix' => '/card', 'middleware' => ['subscription.customer'], 'as' => 'card.'], function () {
            // card index
            Route::get('/', 'SubscriptionCardController@index')->name('index');

            // card store
            Route::post('/', 'SubscriptionCardController@store')->name('store');
        });

        /**
         * Team
         */
        Route::group(['prefix' => '/team', 'middleware' => ['subscription.team'], 'as' => 'team.'], function () {
            // team index
            Route::get('/', 'SubscriptionTeamController@index')->name('index');

            // team update
            Route::put('/', 'SubscriptionTeamController@update')->name('update');

            // store team member
            Route::post('/member', 'SubscriptionTeamMemberController@store')->name('member.store');

            // destroy team member
            Route::delete('/member/{user}', 'SubscriptionTeamMemberController@destroy')->name('member.destroy');
        });
    });
});

/**
 * Admin Group Routes
 */
Route::group(['prefix' => '/admin', 'namespace' => 'Admin\Controllers', 'as' => 'admin.'], function () {

    /**
     * Impersonate destroy
     */
    Route::delete('/users/impersonate', 'User\UserImpersonateController@destroy')->name('users.impersonate.destroy');

    /**
     * Admin Role Middleware Routes
     */
    Route::group(['middleware' => ['auth', 'role:admin']], function () {

        // dashboard
        Route::get('/dashboard', 'AdminDashboardController@index')->name('dashboard');

        /**
         * User Namespace Routes
         */
        Route::group(['namespace' => 'User'], function () {

            /**
             * Users Group Routes
             */
            Route::group(['prefix' => '/users', 'as' => 'users.'], function () {

                /**
                 * User Impersonate Routes
                 */
                Route::group(['prefix' => '/impersonate', 'as' => 'impersonate.'], function () {
                    // index
                    Route::get('/', 'UserImpersonateController@index')->name('index');

                    // store
                    Route::post('/', 'UserImpersonateController@store')->name('store');
                });


                /**
                 * User Group Routes
                 */
                Route::group(['prefix' => '/{user}'], function () {
                    Route::resource('/roles', 'UserRoleController', [
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
                    Route::put('/status', 'PermissionStatusController@toggleStatus')->name('toggleStatus');
                });
            });

            /**
             * Permissions Resource Routes
             */
            Route::resource('/permissions', 'PermissionController');

            /**
             * Roles Group Routes
             */
            Route::group(['prefix' => '/roles', 'as' => 'roles.'], function () {

                /**
                 * Role Group Routes
                 */
                Route::group(['prefix' => '/{role}'], function () {

                    // toggle status
                    Route::put('/status', 'RoleStatusController@toggleStatus')->name('toggleStatus');

                    // revoke users access
                    Route::put('/revoke', 'RoleUsersDisableController@revokeUsersAccess')->name('revokeUsersAccess');

                    /**
                     * Permissions Resource Routes
                     */
                    Route::resource('/permissions', 'RolePermissionController', [
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
            Route::resource('/roles', 'RoleController');

            /**
             * Users Resource Routes
             */
            Route::resource('/users', 'UserController');
        });
    });
});

/**
 * Webhooks Routes
 */
Route::group(['namespace' => 'Webhook\Controllers'], function () {

    // Stripe Webhook
    Route::post('/webhooks/stripe', 'StripeWebhookController@handleWebhook');
});
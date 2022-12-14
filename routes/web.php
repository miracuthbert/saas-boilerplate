<?php

use Illuminate\Support\Facades\Route;
use SAAS\Http\Auth\Controllers\LoginController;
use SAAS\Http\Auth\Controllers\RegisterController;
use SAAS\Http\Auth\Controllers\ResetPasswordController;
use SAAS\Http\Auth\Controllers\ForgotPasswordController;

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
 * Home Route
 */
Route::get('/', [\SAAS\Http\Home\Controllers\HomeController::class, 'index'])->name('home');

/** 
 * Team Routes 
 */
Route::middleware(['auth'])->resource('teams', \SAAS\Http\Teams\Controllers\TeamController::class);

/**
 * Auth Routes
 */

// Authentication Routes...
// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
// Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [ResetPasswordController::class, 'reset']);

/**
 * Activation Group Routes
 */
Route::group(['prefix' => '/activation', 'middleware' => ['guest'], 'as' => 'activation.'], function () {

    // resend index
    Route::get('/resend', [\SAAS\Http\Auth\Controllers\ActivationResendController::class, 'index'])->name('resend');

    // resend store
    Route::post('/resend', [\SAAS\Http\Auth\Controllers\ActivationResendController::class, 'store'])->name('resend.store');

    // activation
    Route::get('/{confirmation_token}', [\SAAS\Http\Auth\Controllers\ActivationController::class, 'activate'])->name('activate');
});

/**
 * Two Factor Login Group Routes
 */
Route::group(['prefix' => '/login/twofactor', 'middleware' => ['guest'], 'as' => 'login.twofactor.'], function () {

    // index
    Route::get('/', [\SAAS\Http\Auth\Controllers\TwoFactorLoginController::class, 'index'])->name('index');

    // store
    Route::post('/', [\SAAS\Http\Auth\Controllers\TwoFactorLoginController::class, 'verify'])->name('verify');
});

/**
 * Plans Routes
 */

/**
 * Plans Group Routes
 */
Route::group(['prefix' => '/plans', 'middleware' => ['subscription.inactive'], 'as' => 'plans.'], function () {

    // teams index
    Route::get('/teams', [\SAAS\Http\Subscriptions\Controllers\PlanTeamController::class, 'index'])->name('teams.index');
});

/**
 * Plans Resource Routes
 */
Route::resource('/plans', \SAAS\Http\Subscriptions\Controllers\PlanController::class, [
    'only' => [
        'index',
        'show'
    ]
])->middleware(['subscription.inactive']);

/**
 * Subscription Resource Routes
 */
Route::resource('/subscription', \SAAS\Http\Subscriptions\Controllers\SubscriptionController::class, [
    'only' => [
        'index',
        'store'
    ]
])->middleware(['auth.register', 'subscription.inactive']);

/**
 * Developer Routes.
 *
 * Handles developer routes.
 */
Route::middleware(['auth'])->prefix('/developers')->name('developer.')->group(function () {

    // index
    Route::get('/', [\SAAS\Http\Developer\Controllers\DeveloperController::class, 'index'])->name('index');
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
Route::prefix('account')->middleware(['auth', 'verified'])->name( 'account.')->group(function () {

    /**
     * Dashboard
     */
    Route::get('/dashboard', [\SAAS\Http\Account\Controllers\DashboardController::class, 'index'])->name('dashboard');

    /**
     * Companies Resource Routes
     */
    Route::resource('/companies', \SAAS\Http\Account\Controllers\Company\CompanyController::class, [
        'only' => [
            'index',
            'create',
            'store'
        ]
    ]);

    /**
     * Account Overview
     */
    // account index
    Route::get('/', [\SAAS\Http\Account\Controllers\AccountController::class, 'index'])->name('index');

    /**
     * Profile
     */
    // profile index
    Route::get('/profile', [\SAAS\Http\Account\Controllers\ProfileController::class, 'index'])->name('profile.index');

    // profile update
    Route::post('/profile', [\SAAS\Http\Account\Controllers\ProfileController::class, 'store'])->name('profile.store');

    /**
     * Password
     */
    // password index
    Route::get('/password', [\SAAS\Http\Account\Controllers\PasswordController::class, 'index'])->name('password.index');

    // password store
    Route::post('/password', [\SAAS\Http\Account\Controllers\PasswordController::class, 'store'])->name('password.store');

    /**
     * Deactivate
     */
    // deactivate account index
    Route::get('/deactivate', [\SAAS\Http\Account\Controllers\DeactivateController::class, 'index'])->name('deactivate.index');

    // deactivate store
    Route::post('/deactivate', [\SAAS\Http\Account\Controllers\DeactivateController::class, 'store'])->name('deactivate.store');

    /**
     * Two factor
     */
    Route::group(['prefix' => '/twofactor', 'as' => 'twofactor.'], function () {
        // two factor index
        Route::get('/', [\SAAS\Http\Account\Controllers\TwoFactorController::class, 'index'])->name('index');

        // two factor store
        Route::post('/', [\SAAS\Http\Account\Controllers\TwoFactorController::class, 'store'])->name('store');

        // two factor verify
        Route::post('/verify', [\SAAS\Http\Account\Controllers\TwoFactorController::class, 'verify'])->name('verify');

        // two factor verify
        Route::delete('/', [\SAAS\Http\Account\Controllers\TwoFactorController::class, 'destroy'])->name('destroy');
    });

    /**
     * Tokens
     */
    Route::group(['prefix' => '/tokens', 'as' => 'tokens.'], function () {
        // personal access token index
        Route::get('/', [\SAAS\Http\Account\Controllers\PersonalAccessTokenController::class, 'index'])->name('index');
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
            Route::get('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionCancelController::class, 'index'])->name('index');

            // cancel subscription
            Route::post('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionCancelController::class, 'store'])->name('store');
        });

        /**
         * Resume
         *
         * Accessed if subscription is cancelled but not expired.
         */
        Route::group(['prefix' => '/resume', 'middleware' => ['subscription.cancelled'], 'as' => 'resume.'], function () {
            // resume subscription index
            Route::get('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionResumeController::class, 'index'])->name('index');

            // resume subscription
            Route::post('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionResumeController::class, 'store'])->name('store');
        });

        /**
         * Swap Subscription
         *
         * Accessed if there is an active subscription.
         */
        Route::group(['prefix' => '/swap', 'middleware' => ['subscription.notcancelled'], 'as' => 'swap.'], function () {
            // swap subscription index
            Route::get('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionSwapController::class, 'index'])->name('index');

            // swap subscription store
            Route::post('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionSwapController::class, 'store'])->name('store');
        });

        /**
         * Card
         */
        Route::group(['prefix' => '/card', 'middleware' => ['subscription.customer'], 'as' => 'card.'], function () {
            // card index
            Route::get('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionCardController::class, 'index'])->name('index');

            // card store
            Route::post('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionCardController::class, 'store'])->name('store');
        });

        /**
         * Team
         */
        Route::group(['prefix' => '/team', 'middleware' => ['subscription.team'], 'as' => 'team.'], function () {
            // team index
            Route::get('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionTeamController::class, 'index'])->name('index');

            // team update
            Route::put('/', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionTeamController::class, 'update'])->name('update');

            // store team member
            Route::post('/member', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionTeamMemberController::class, 'store'])->name('member.store');

            // destroy team member
            Route::delete('/member/{user}', [\SAAS\Http\Account\Controllers\Subscription\SubscriptionTeamMemberController::class, 'destroy'])->name('member.destroy');
        });
    });
});

/**
 * Webhooks Routes
 */
Route::group(['namespace' => 'Webhook\Controllers'], function () {

    // Stripe Webhook
    Route::post('/webhooks/stripe', [\SAAS\Http\Webhook\Controllers\StripeWebhookController::class, 'handleWebhook']);
});

/**
 * Impersonate destroy
 */
Route::delete('/admin/users/impersonate', [\SAAS\Http\Admin\Controllers\User\UserImpersonateController::class, 'destroy'])->name('admin.users.impersonate.destroy');

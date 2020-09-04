<?php

namespace SAASBoilerplate\Http;

use SAASBoilerplate\Http\Middleware\AbortIfHasNoPermission;
use SAASBoilerplate\Http\Middleware\AbortIfHasNoRole;
use SAASBoilerplate\Http\Middleware\Admin\Impersonate;
use SAASBoilerplate\Http\Middleware\AuthenticateRegister;
use SAASBoilerplate\Http\Middleware\ChecksExpiredConfirmationTokens;
use SAASBoilerplate\Http\Middleware\EncryptCookies;
use SAASBoilerplate\Http\Middleware\RedirectIfAuthenticated;
use SAASBoilerplate\Http\Middleware\Subscription\RedirectIfCancelled;
use SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotActive;
use SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotCancelled;
use SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotCustomer;
use SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNoTeamPlan;
use SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotInactive;
use SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotSubscriptionOwner;
use SAASBoilerplate\Http\Middleware\Tenant\TenantConfigMiddleware;
use SAASBoilerplate\Http\Middleware\Tenant\TenantMiddleware;
use SAASBoilerplate\Http\Middleware\TrimStrings;
use SAASBoilerplate\Http\Middleware\TrustProxies;
use SAASBoilerplate\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            Impersonate::class,
        ],

        'tenant' => [
            TenantMiddleware::class,
            TenantConfigMiddleware::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'throttle' => ThrottleRequests::class,
        'confirmation_token.expired' => ChecksExpiredConfirmationTokens::class,
        'role' => AbortIfHasNoRole::class,
        'permission' => AbortIfHasNoPermission::class,
        'auth.register' => AuthenticateRegister::class,
        'subscription.active' => RedirectIfNotActive::class,
        'subscription.notcancelled' => RedirectIfCancelled::class,
        'subscription.cancelled' => RedirectIfNotCancelled::class,
        'subscription.customer' => RedirectIfNotCustomer::class,
        'subscription.inactive' => RedirectIfNotInactive::class,
        'subscription.team' => RedirectIfNoTeamPlan::class,
        'subscription.owner' => RedirectIfNotSubscriptionOwner::class,
    ];
}

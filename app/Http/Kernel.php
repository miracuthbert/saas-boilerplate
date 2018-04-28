<?php

namespace SAASBoilerplate\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

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
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \SAASBoilerplate\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \SAASBoilerplate\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \SAASBoilerplate\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \SAASBoilerplate\Http\Middleware\VerifyCsrfToken::class,
            \SAASBoilerplate\Http\Middleware\Admin\Impersonate::class,
        ],

        'tenant' => [
            \SAASBoilerplate\Http\Middleware\Tenant\TenantMiddleware::class,
            \SAASBoilerplate\Http\Middleware\Tenant\TenantConfigMiddleware::class,
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
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \SAASBoilerplate\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'confirmation_token.expired' => \SAASBoilerplate\Http\Middleware\ChecksExpiredConfirmationTokens::class,
        'role' => \SAASBoilerplate\Http\Middleware\AbortIfHasNoRole::class,
        'permission' => \SAASBoilerplate\Http\Middleware\AbortIfHasNoPermission::class,
        'auth.register' => \SAASBoilerplate\Http\Middleware\AuthenticateRegister::class,
        'subscription.active' => \SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotActive::class,
        'subscription.notcancelled' => \SAASBoilerplate\Http\Middleware\Subscription\RedirectIfCancelled::class,
        'subscription.cancelled' => \SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotCancelled::class,
        'subscription.customer' => \SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotCustomer::class,
        'subscription.inactive' => \SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotInactive::class,
        'subscription.team' => \SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNoTeamPlan::class,
        'subscription.owner' => \SAASBoilerplate\Http\Middleware\Subscription\RedirectIfNotSubscriptionOwner::class,
    ];
}

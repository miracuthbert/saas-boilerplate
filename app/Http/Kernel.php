<?php

namespace SAAS\Http;

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
        // \SAAS\Http\Middleware\TrustHosts::class,
        \SAAS\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        // \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \SAAS\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \SAAS\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \SAAS\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \SAAS\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \SAAS\Http\Middleware\Admin\Impersonate::class,
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
        'guest' => \SAAS\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \SAAS\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'confirmation_token.expired' => \SAAS\Http\Middleware\ChecksExpiredConfirmationTokens::class,
        'auth.register' => \SAAS\Http\Middleware\AuthenticateRegister::class,
        'subscription.active' => \SAAS\Http\Middleware\Subscription\RedirectIfNotActive::class,
        'subscription.notcancelled' => \SAAS\Http\Middleware\Subscription\RedirectIfCancelled::class,
        'subscription.cancelled' => \SAAS\Http\Middleware\Subscription\RedirectIfNotCancelled::class,
        'subscription.customer' => \SAAS\Http\Middleware\Subscription\RedirectIfNotCustomer::class,
        'subscription.inactive' => \SAAS\Http\Middleware\Subscription\RedirectIfNotInactive::class,
        'subscription.team' => \SAAS\Http\Middleware\Subscription\RedirectIfNoTeamPlan::class,
        'subscription.owner' => \SAAS\Http\Middleware\Subscription\RedirectIfNotSubscriptionOwner::class,
        'tenant.config' => \SAAS\Http\Middleware\Tenant\TenantConfigMiddleware::class,
    ];
}

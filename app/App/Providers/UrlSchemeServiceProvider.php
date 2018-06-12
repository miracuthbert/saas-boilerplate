<?php

namespace SAASBoilerplate\App\Providers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class UrlSchemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @param UrlGenerator $url
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if(env('FORCE_HTTPS') === true) {
            $url->forceScheme('https');
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace SAAS\App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Appends a helper file to be loaded with the app
     *
     * @var array
     */
    protected $helpers = [
        'helpers'
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->helpers as $helper) {
            $helper_path = app_path() . '/App/Helpers/' . $helper . '.php';

            if (File::isFile($helper_path)) {
                require_once $helper_path;
            }
        }
    }
}

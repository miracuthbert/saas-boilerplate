<?php

namespace SAAS\App\Console\Commands;

use Illuminate\Foundation\Console\ProviderMakeCommand;

class DomainProviderMakeCommand extends ProviderMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\App\Providers';
    }
}

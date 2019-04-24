<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\RequestMakeCommand;

class DomainRequestMakeCommand extends RequestMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http';
    }
}

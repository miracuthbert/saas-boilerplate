<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\ExceptionMakeCommand;

class DomainExceptionMakeCommand extends ExceptionMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\App\Exceptions';
    }
}

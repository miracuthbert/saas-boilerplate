<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\EventMakeCommand;

class DomainEventMakeCommand extends EventMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Domain';
    }
}

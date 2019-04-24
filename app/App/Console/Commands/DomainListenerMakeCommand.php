<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\ListenerMakeCommand;

class DomainListenerMakeCommand extends ListenerMakeCommand
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

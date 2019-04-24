<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\ConsoleMakeCommand;

class DomainConsoleMakeCommand extends ConsoleMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\App\Console\Commands';
    }
}

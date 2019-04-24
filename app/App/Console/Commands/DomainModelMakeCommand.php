<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;

class DomainModelMakeCommand extends ModelMakeCommand
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

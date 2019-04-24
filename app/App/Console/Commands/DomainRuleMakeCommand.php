<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\RuleMakeCommand;

class DomainRuleMakeCommand extends RuleMakeCommand
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

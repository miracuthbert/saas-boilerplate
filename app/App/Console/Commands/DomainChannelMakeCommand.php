<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\ChannelMakeCommand;

class DomainChannelMakeCommand extends ChannelMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\App\Broadcasting';
    }
}

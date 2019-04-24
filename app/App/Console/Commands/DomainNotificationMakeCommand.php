<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\NotificationMakeCommand;

class DomainNotificationMakeCommand extends NotificationMakeCommand
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

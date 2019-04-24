<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\ResourceMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class DomainResourceMakeCommand extends ResourceMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('global')) {
            return $rootNamespace . '\App\Resources';
        }

        return $rootNamespace . '\Domain';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = [
            ['global', 'g', InputOption::VALUE_NONE, 'Indicates if the generated resource should be a global resource.'],
        ];

        return array_merge(parent::getOptions(), $options);
    }
}

<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\PolicyMakeCommand;

class DomainPolicyMakeCommand extends PolicyMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'domain:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new domain driven policy class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Policy';

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

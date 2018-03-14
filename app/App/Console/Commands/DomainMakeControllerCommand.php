<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Routing\Console\ControllerMakeCommand;

class DomainMakeControllerCommand extends ControllerMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'domain:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new domain driven controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('parent')) {
            return __DIR__.'/stubs/controller.nested.stub';
        } elseif ($this->option('model')) {
            return __DIR__.'/stubs/controller.model.stub';
        } elseif ($this->option('resource')) {
            return __DIR__.'/stubs/controller.stub';
        }

        return __DIR__.'/stubs/controller.plain.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http';
    }
}

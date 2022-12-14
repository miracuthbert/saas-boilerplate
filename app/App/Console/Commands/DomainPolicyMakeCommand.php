<?php

namespace SAAS\App\Console\Commands;

use Illuminate\Foundation\Console\PolicyMakeCommand;
use Illuminate\Support\Str;

class DomainPolicyMakeCommand extends PolicyMakeCommand
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

    /**
     * Replace the model for the given stub.
     *
     * @param  string $stub
     * @param  string $model
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $model = str_replace('/', '\\', $model);

        $namespaceModel = $this->laravel->getNamespace() . 'Domain\\' . $model;

        if (Str::startsWith($model, '\\')) {
            $stub = str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
        } else {
            $stub = str_replace('NamespacedDummyModel', $namespaceModel, $stub);
        }

        $stub = str_replace(
            "use {$namespaceModel};\nuse {$namespaceModel};", "use {$namespaceModel};", $stub
        );

        $model = class_basename(trim($model, '\\'));

        $dummyUser = class_basename(config('auth.providers.users.model'));

        $dummyModel = Str::camel($model) === 'user' ? 'model' : Str::camel($model);

        $stub = str_replace('DummyModel', $model, $stub);

        $stub = str_replace('dummyModel', $dummyModel, $stub);

        $stub = str_replace('DummyUser', $dummyUser, $stub);

        return str_replace('dummyPluralModel', Str::plural($dummyModel), $stub);
    }
}

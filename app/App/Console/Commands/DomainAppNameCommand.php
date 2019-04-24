<?php

namespace SAASBoilerplate\App\Console\Commands;

use Illuminate\Foundation\Console\AppNameCommand;

class DomainAppNameCommand extends AppNameCommand
{
    /**
     * Set the bootstrap namespaces.
     *
     * @return void
     */
    protected function setBootstrapNamespaces()
    {
        $search = [
            $this->currentRoot . '\\Http',
            $this->currentRoot . '\\App\\Console',
            $this->currentRoot . '\\App\\Exceptions',
        ];

        $replace = [
            $this->argument('name') . '\\Http',
            $this->argument('name') . '\\App\\Console',
            $this->argument('name') . '\\App\\Exceptions',
        ];

        $this->replaceIn($this->getBootstrapPath(), $search, $replace);
    }

    /**
     * Set the application provider namespaces.
     *
     * @return void
     */
    protected function setAppConfigNamespaces()
    {
        $search = [
            $this->currentRoot . '\\App\\Providers',
            $this->currentRoot . '\\Http\\Controllers\\',
        ];

        $replace = [
            $this->argument('name') . '\\App\\Providers',
            $this->argument('name') . '\\Http\\Controllers\\',
        ];

        $this->replaceIn($this->getConfigPath('app'), $search, $replace);
    }

    /**
     * Set the authentication User namespace.
     *
     * @return void
     */
    protected function setAuthConfigNamespace()
    {
        $this->replaceIn(
            $this->getConfigPath('auth'),
            $this->currentRoot . '\\Domain\\Users\\Models\\User',
            $this->argument('name') . '\\Domain\\Users\\Models\\User'
        );
    }

    /**
     * Set the services User namespace.
     *
     * @return void
     */
    protected function setServicesConfigNamespace()
    {
        $this->replaceIn(
            $this->getConfigPath('services'),
            $this->currentRoot . '\\Domain\\Users\\Models\\User',
            $this->argument('name') . '\\Domain\\Users\\Models\\User'
        );
    }
}

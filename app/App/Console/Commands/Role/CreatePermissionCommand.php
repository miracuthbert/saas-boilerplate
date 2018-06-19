<?php

namespace SAASBoilerplate\App\Console\Commands\Role;

use Illuminate\Console\Command;
use SAASBoilerplate\Domain\Users\Models\Permission;
use SAASBoilerplate\Domain\Users\Models\Role;

class CreatePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-permission {action} {name} {usable=true} {--role=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user permission with an option of to assign a role to it';

    /**
     * @var Permission
     */
    private $permission;

    /**
     * @var Role
     */
    private $role;

    /**
     * Create a new command instance.
     *
     * @param Permission $permission
     * @param Role $role
     */
    public function __construct(Permission $permission, Role $role)
    {
        parent::__construct();

        $this->permission = $permission;
        $this->role = $role;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // arguments
        $arguments = array_only($this->arguments(), ['action', 'name']);

        // permission name
        $name = join(' ', $arguments);

        // permission usable
        $usable = $this->argument('usable');

        // role slug
        $slug = $this->option('role', null);

        try {
            // find role or set null
            $role = $slug != 'null' ? $this->role->where('slug', $slug)->firstOrFail() : null;

            if ($this->confirm(sprintf("Are you sure you want to create '%s' permission?", $name))) {

                // create permission
                $permission = $this->permission->fill([
                    'name' => $name,
                    'usable' => boolval($usable)
                ]);
                $permission->save();

                // print success
                $this->info(sprintf('Created permission: `%s`', $name));

                if ($role != null && !$role->permissions->contains($permission)) {

                    $role->permissions()->attach($permission);

                    // print success
                    $this->info(sprintf('Assigned permission: `%s` to `%s` role', $name, $role->name));
                }
            }
        } catch (\Exception $exception) {
            $this->error(
                sprintf(
                    'Whoops! we could not create permission because: %s',
                    $exception->getMessage()
                )
            );
        }
    }
}

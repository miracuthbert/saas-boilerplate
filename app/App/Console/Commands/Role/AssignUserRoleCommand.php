<?php

namespace SAAS\App\Console\Commands\Role;

use Carbon\Carbon;
use Illuminate\Console\Command;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\User;

class AssignUserRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:assign-role {email} {role} {--days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign user a role by passing in email and role slug, with an option to expire after days';

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Role
     */
    protected $role;

    /**
     * Create a new command instance.
     *
     * @param User $user
     * @param Role $role
     */
    public function __construct(User $user, Role $role)
    {
        parent::__construct();

        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // user email
        $email = $this->argument('email');

        // role slug
        $slug = $this->argument('role');

        // no. of days
        $days = $this->option('days', null);

        // user role expiry date
        $expires_at = $days != null ? Carbon::now()->addDays($days) : null;

        try {
            // find user and role
            $user = $this->user->where('email', $email)->firstOrFail();
            $role = $this->role->where('slug', $slug)->firstOrFail();

            if ($this->confirm(
                sprintf("Are you sure you want to assign `%s` role to `%s`?",
                    $role->name, $user->name))) {

                // assign role
                $user->assignRole($role, $expires_at);

                // print success
                $this->info(sprintf('Assigned role: `%s` to `%s`', $role->name, $user->name));
            }
        } catch (\Exception $exception) {
            $this->error(
                sprintf(
                    'Whoops! we could not assign user a role because: %s',
                    $exception->getMessage()
                )
            );
        }

    }
}

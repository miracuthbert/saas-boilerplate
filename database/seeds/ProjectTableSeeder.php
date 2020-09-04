<?php

use SAASBoilerplate\Domain\Company\Models\Company;
use SAASBoilerplate\Domain\Projects\Models\Project;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::limit(2)->get();

        $companies->each(function ($u) {
            $u->projects()->saveMany(factory(Project::class, 5)->make());
        });

    }
}

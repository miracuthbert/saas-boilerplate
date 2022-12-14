<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \SAAS\Domain\Users\Models\User::factory(10)->create();
        $this->call(CountrySeeder::class);
        $this->call(PlanTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
    }
}

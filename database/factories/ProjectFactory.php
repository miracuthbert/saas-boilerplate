<?php

use SAASBoilerplate\Domain\Projects\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->words(3, true),
        'slug' => $faker->unique()->slug(3),
    ];
});

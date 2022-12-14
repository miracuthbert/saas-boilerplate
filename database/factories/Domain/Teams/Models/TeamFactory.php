<?php

namespace Database\Factories\Domain\Teams\Models;

use SAAS\Domain\Teams\Models\Team;
use SAAS\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'user_id' => User::factory(),
            // 'personal_team' => true,
        ];
    }
}

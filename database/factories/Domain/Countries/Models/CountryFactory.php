<?php

namespace Database\Factories\Domain\Countries\Models;

use SAAS\Domain\Countries\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->country,
            'code' => $this->faker->unique()->countryCode,
            //            'dial_code' => $this->faker->unique()->countryISOAlpha3,
        ];
    }
}

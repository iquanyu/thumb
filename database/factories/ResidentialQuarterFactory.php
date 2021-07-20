<?php

namespace Database\Factories;

use App\Models\ResidentialQuarter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentialQuarterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResidentialQuarter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->streetName,
            'address' => $this->faker->streetAddress,
        ];
    }
}

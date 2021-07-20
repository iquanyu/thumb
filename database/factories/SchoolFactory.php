<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = School::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $school_name_arr = [
            '第一小学',
            '第二小学',
            '第三小学',
            '第四小学',
            '墨尔根小学',
            '第一小学',
            '第一小学',
            '第一小学',
            '第一小学',
            '第一小学',
            '墨尔根小学',
        ];
        return [
            'area_id' => 1,
            'name'    => $school_name_arr[$this->faker->randomDigit],
            'address' => $this->faker->address,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'school_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'grade_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'gender' => 'm',
            'username' => $this->faker->name(),
            'birthday' => Carbon::now()->modify('-2 years')->toDateString(),
            'residential_quarter_id' => $this->faker->randomDigitNotNull,
        ];
    }
}

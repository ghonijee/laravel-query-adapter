<?php

namespace Floo\DxAdapter\Database\Factories;

use Floo\DxAdapter\Models\TestModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = ['male', 'female'];
        $active = [true, false];
        $random = rand(0, 1);
        return [
            'name' => $this->faker->name($gender[$random]),
            'last_name' => $this->faker->lastName(),
            'address' => $this->faker->address(),
            'gender' => $gender[$random],
            'active' => $active[$random]
        ];
    }
}

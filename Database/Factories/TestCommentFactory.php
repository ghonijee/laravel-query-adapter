<?php

namespace Floo\DxAdapter\Database\Factories;

use Floo\DxAdapter\Models\TestComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->text()
        ];
    }
}

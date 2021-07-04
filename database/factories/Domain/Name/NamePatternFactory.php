<?php

namespace Database\Factories\Domain\Name;

use App\Domain\Name\NamePattern;
use Illuminate\Database\Eloquent\Factories\Factory;

class NamePatternFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NamePattern::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
        ];
    }
}

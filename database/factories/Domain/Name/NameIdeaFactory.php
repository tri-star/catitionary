<?php

namespace Database\Factories\Domain\Name;

use App\Domain\Name\NameIdea;
use Illuminate\Database\Eloquent\Factories\Factory;

class NameIdeaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NameIdea::class;

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

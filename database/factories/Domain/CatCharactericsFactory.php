<?php

namespace Database\Factories\Domain;

use App\Domain\CatCharacterics;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatCharactericsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CatCharacterics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $base = $this->faker->unique()->word;
        return [
            'id'   => "character-id-{$base}",
            'name' => "character-name-{$base}",
        ];
    }
}

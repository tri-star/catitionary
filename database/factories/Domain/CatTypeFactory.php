<?php

namespace Database\Factories\Domain;

use App\Domain\CatType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CatType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $base = $this->faker->unique()->word;
        return [
            'id'   => "id-{$base}",
            'name' => "name-{$base}",
        ];
    }
}

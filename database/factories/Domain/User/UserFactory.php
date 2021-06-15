<?php

namespace Database\Factories\Domain\User;

use App\Domain\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                    => $this->faker->name(),
            'login_id'                => $this->faker->unique()->word(),
            'email'                   => $this->faker->unique()->safeEmail(),
            'email_verified_at'       => now(),
            'email_verification_code' => User::generateEmailVerificationCode(),
            'password'                => 'password',
            'remember_token'          => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

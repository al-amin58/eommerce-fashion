<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['I', 'B']);
        $name =null;
        $name == "I" ? $this->faker->name() : $this->faker->company();
        return [
            "user_id" => User::factory(),
            "type" => $type,
        ];
    }
}

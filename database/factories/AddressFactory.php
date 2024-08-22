<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'address' => $this->faker->address(),
            'country_id' => $this->faker->biasedNumberBetween(10, 250),
            'state_id' => $this->faker->biasedNumberBetween(1, 5116),
            'city_id'    => $this->faker->biasedNumberBetween(501, 153350),
            'postal_code' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'set_default' => $this->faker->boolean(),
        ];
    }
}

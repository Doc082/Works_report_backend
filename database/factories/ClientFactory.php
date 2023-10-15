<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Provider\it_IT\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'name' => $this->faker->name(),
            'enterprise' => $this->faker->word(),
            'iva' => $this->faker->randomNumber(5, true),
            'user_id' => $user->id,
            'address' => $this->faker->address(),
        ];
    }
}

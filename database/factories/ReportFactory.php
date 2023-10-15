<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $client = Client::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'client_id' => $client->id,
            'date' => $this->faker->dateTime(),
            'people' => $this->faker->numberBetween(1,4),
            'hour' => $this->faker->numberBetween(1,8),
            'description' => $this->faker->text(),
        ];
    }
}

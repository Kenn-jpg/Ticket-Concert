<?php

namespace Database\Factories;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ticketType = fake()->randomElement(array_keys(Registration::TICKET_PRICES));
        $quantity = fake()->numberBetween(1, Registration::MAX_QUANTITY);

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '08'.fake()->numerify('##########'),
            'ticket_type' => $ticketType,
            'quantity' => $quantity,
            'payment_method' => fake()->randomElement(Registration::PAYMENT_METHODS),
            'total_price' => Registration::TICKET_PRICES[$ticketType] * $quantity,
        ];
    }
}

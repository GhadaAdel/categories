<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'COD', null];

        return [
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement($statuses),
            'total_price' => $this->faker->randomFloat(2, 10, 1000),
            'shipping_address' => $this->faker->address(),
            'billing_address' => $this->faker->address(),
            'placed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'shipped_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

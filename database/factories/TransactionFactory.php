<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['income', 'expense']),
            'title' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'expense_date' => $this->faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
        ];
    }
}

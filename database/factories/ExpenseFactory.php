<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTime,
            'date_to' => $this->faker->date,
            'description' => $this->faker->sentence(15),
            'budget' => $this->faker->randomNumber(2),
            'cluster_id' => \App\Models\Cluster::factory(),
            'assign_id' => \App\Models\Assign::factory(),
            'account_id' => \App\Models\Account::factory(),
        ];
    }
}

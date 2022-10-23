<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'cost' => $this->faker->randomNumber(2),
            'description' => $this->faker->sentence(15),
            'account_id' => \App\Models\Account::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Executed;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExecutedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Executed::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cost' => $this->faker->randomNumber(2),
            'description' => $this->faker->sentence(15),
            'expense_id' => \App\Models\Expense::factory(),
            'type_id' => \App\Models\Type::factory(),
        ];
    }
}

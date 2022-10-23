<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'number' => $this->faker->text(255),
            'type' => 'Ahorro',
            'owner' => $this->faker->text(255),
            'bank_id' => \App\Models\Bank::factory(),
        ];
    }
}

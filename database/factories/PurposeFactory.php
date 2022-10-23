<?php

namespace Database\Factories;

use App\Models\Purpose;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurposeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Purpose::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'code' => $this->faker->word(255),
            'color_id' => \App\Models\Color::factory(),
        ];
    }
}

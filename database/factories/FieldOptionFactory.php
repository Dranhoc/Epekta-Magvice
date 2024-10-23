<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FieldOption>
 */
class FieldOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => ['name' => $this->faker->word()],
            'price' => $this->faker->randomFloat(2, 10),
            'amount' => $this->faker->randomFloat(2, 10),
        ];
    }
}

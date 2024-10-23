<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\FieldOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FieldRule>
 */
class FieldRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'operator' => $this->faker->word(),
            'field_option_id' => FieldOption::factory(),
        ];
    }
}

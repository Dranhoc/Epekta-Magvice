<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormField>
 */
class FormFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'label' => ['key' => $this->faker->word()],
            'type' => $this->faker->word(),
            'placeholder' => ['key' => $this->faker->word()],
            'column' => $this->faker->word(),
            'tooltip' => ['key' => $this->faker->word()],
            'is_required' => $this->faker->boolean(),
            'has_multiple_choices' => $this->faker->boolean(),
            'prefix' => $this->faker->word(),
            'suffix' => $this->faker->word(),
            'is_and' => $this->faker->boolean(),
            'is_shown' => $this->faker->boolean(),
            'with_label' => $this->faker->boolean(),
            'model_reference' => $this->faker->word(),
        ];
    }
}

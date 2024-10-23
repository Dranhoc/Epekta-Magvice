<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PageFactory extends Factory
{
    protected $model = Page::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->words(),
            'template' => $this->faker->word(),
            'method' => $this->faker->word(),
            'seo_title' => $this->faker->words(),
            'seo_description' => $this->faker->text(),
            'seo_type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ContentFactory extends Factory
{
    protected $model = Content::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'title' => $this->faker->word(),
            'sur_title' => $this->faker->word(),
            'subtitle' => $this->faker->word(),
            'picture_alt' => $this->faker->word(),
            'content' => $this->faker->word(),
            'type' => $this->faker->randomNumber(),
            'order_column' => $this->faker->randomNumber(),
            'contentable_id' => $this->faker->randomNumber(),
            'contentable_type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'page_id' => Page::factory(),
        ];
    }
}

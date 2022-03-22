<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KnowledgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 10),
            'question' => $this->faker->text(20),
            'answer' => $this->faker->text(100),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    public function definition()
    {
        $types = ['rating', 'comment-only', 'multiple-choice'];
        
        return [
            'name' => $this->faker->words(3, true),
            'question_text' => $this->faker->sentence(10) . '?',
            'question_type' => $this->faker->randomElement($types),
        ];
    }
}
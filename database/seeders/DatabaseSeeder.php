<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $surveys = Survey::factory(10)->create();
        $questions = Question::factory(50)->create();

        $surveys->each(function ($survey) use ($questions) {
            $survey->questions()->attach(
                $questions->random(rand(5, 15))->pluck('id')->toArray()
            );
        });
    }
}

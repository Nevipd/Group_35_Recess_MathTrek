<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Challenge;
use App\Models\Participant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create some challenges, participants, and link them in the pivot table
        $challenge = Challenge::create([
            'name' => 'Math Challenge',
            'description' => 'Test your math skills',
            'start_date' => now(),
            'end_date' => now()->addWeek(),
            'num_questions' => 10,
            'duration' => 60,
            'time_per_question' => 6,
        ]);

        $participant = Participant::create([
            'username' => 'john_doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'date_of_birth' => '2000-01-01',
            'image_file'=> 'NONE',
            'school_registration_number' => 'UO391',
        ]);

        $challenge->participants()->attach($participant->id, ['marks' => 80]);
    }
}

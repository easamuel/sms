<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sms\SmsClub;
use App\Models\Sms\SmsSchool;

class SmsClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all schools
        $schools = SmsSchool::all();

        if ($schools->isEmpty()) {
            $this->command->warn('No schools found. Please create a school first.');
            return;
        }

        // Common clubs for Nigerian schools
        $commonClubs = [
            ['name' => 'Press Club', 'category' => 'Media', 'description' => 'Journalism and media activities'],
            ['name' => 'Debate Club', 'category' => 'Academic', 'description' => 'Debating and public speaking'],
            ['name' => 'Science Club', 'category' => 'Academic', 'description' => 'Science experiments and projects'],
            ['name' => 'Mathematics Club', 'category' => 'Academic', 'description' => 'Mathematics competitions and problem solving'],
            ['name' => 'Literary and Drama Society', 'category' => 'Arts', 'description' => 'Drama, poetry, and literature'],
            ['name' => 'Music Club', 'category' => 'Arts', 'description' => 'Music, choir, and band activities'],
            ['name' => 'Art Club', 'category' => 'Arts', 'description' => 'Drawing, painting, and creative arts'],
            ['name' => 'Football Team', 'category' => 'Sports', 'description' => 'Football and soccer activities'],
            ['name' => 'Basketball Team', 'category' => 'Sports', 'description' => 'Basketball activities'],
            ['name' => 'Athletics Club', 'category' => 'Sports', 'description' => 'Track and field events'],
            ['name' => 'Volleyball Team', 'category' => 'Sports', 'description' => 'Volleyball activities'],
            ['name' => 'Table Tennis Club', 'category' => 'Sports', 'description' => 'Table tennis activities'],
            ['name' => 'Chess Club', 'category' => 'Academic', 'description' => 'Chess and strategy games'],
            ['name' => 'Red Cross Society', 'category' => 'Service', 'description' => 'First aid and humanitarian activities'],
            ['name' => 'Environmental Club', 'category' => 'Service', 'description' => 'Environmental awareness and conservation'],
            ['name' => 'ICT Club', 'category' => 'Academic', 'description' => 'Information and Communication Technology'],
            ['name' => 'French Club', 'category' => 'Academic', 'description' => 'French language and culture'],
            ['name' => 'JETS Club', 'category' => 'Academic', 'description' => 'Junior Engineers, Technicians and Scientists'],
        ];

        foreach ($schools as $school) {
            // Check if clubs already exist for this school
            $existingClubs = SmsClub::where('school_id', $school->id)->count();
            
            if ($existingClubs > 0) {
                $this->command->info("Clubs already exist for {$school->name}. Skipping...");
                continue;
            }

            foreach ($commonClubs as $clubData) {
                SmsClub::create([
                    'school_id' => $school->id,
                    'name' => $clubData['name'],
                    'category' => $clubData['category'],
                    'description' => $clubData['description'],
                    'teacher_id' => null, // Can be assigned later
                    'is_active' => true,
                ]);
            }

            $this->command->info("Created " . count($commonClubs) . " clubs for {$school->name}");
        }
    }
}

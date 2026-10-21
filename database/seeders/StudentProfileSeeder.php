<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;

class StudentProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['PM', 'FE', 'BE', 'UI/UX'];
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'),
            ]);

            StudentProfile::create([
                'user_id' => $user->id,
                'role_1' => fake()->randomElement($roles),
                'role_2' => fake()->randomElement($roles),
                'skill_score' => fake()->numberBetween(0, 100),
            ]);
        }
    }
}
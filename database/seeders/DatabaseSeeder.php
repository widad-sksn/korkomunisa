<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Korkom',
            'email' => 'admin@korkom.unisayogya.ac.id',
            'password' => bcrypt('immkorkom2024@#'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Kader User',
            'email' => 'kader@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}

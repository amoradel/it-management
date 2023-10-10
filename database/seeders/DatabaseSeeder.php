<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret123'),
            // 'profile_photo_path' => 'https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg',
        ]);

        $this->call(IpSeeder::class);
    }
}

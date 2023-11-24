<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        // for ($i = 0; $i < 10; $i++) {
        //     \App\Models\Brand::create([
        //         'name' => Str::random(10),
        //     ]);
        // }

        // for ($i = 0; $i < 10; $i++) {
        //     \App\Models\DeviceModel::create([
        //         'name' => Str::random(10),
        //         'brand_id' => rand(1, 10),
        //     ]);
        // }

        // $device_types = [
        //     'computer',
        //     'printer',
        //     'camera',
        //     'monitor',
        //     'pos',
        //     'dvr',
        //     'others',
        // ];

        // for ($i = 0; $i < 10; $i++) {
        //     \App\Models\Type::create([
        //         'name' => Str::random(10),
        //         'device_type' => $device_types[mt_rand(0, count($device_types) - 1)],
        //     ]);
        // }

        $this->call(IpSeeder::class);
    }
}

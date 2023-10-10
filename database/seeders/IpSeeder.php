<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 127; $j++) {
                \App\Models\Ip::create([
                    'ip_number' => '192.168.' . $i . '.' . $j,
                    'ip_type' => 'Estática',
                    'segment' => '192.168.' . $i . '.1 - 192.168.' . $i . '.127',
                    'availability' => 'Disponible',
                    'status' => 1,
                ]);
            }
        }
    }
}

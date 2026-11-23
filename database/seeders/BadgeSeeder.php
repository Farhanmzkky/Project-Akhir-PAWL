<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            ['First Step', 'Selesaikan 1 misi.', '🌱', 'completed', 1],
            ['Eco Starter', 'Capai Level 2.', '🌿', 'level', 2],
            ['Plastic Hero', 'Selesaikan 3 misi kategori Daur ulang.', '♻️', 'recycling', 3],
            ['Eco Guardian', 'Capai Level 3.', '🌳', 'level', 3],
            ['Community Leader', 'Selesaikan 2 misi kategori Komunitas.', '🤝', 'community', 2],
            ['Eco Legend', 'Capai Level 5.', '🏆', 'level', 5],
        ];

        foreach ($badges as [$name, $description, $icon, $key, $value]) {
            Badge::firstOrCreate(['name' => $name], [
                'description' => $description, 'icon' => $icon,
                'criteria_key' => $key, 'criteria_value' => $value,
            ]);
        }
    }
}

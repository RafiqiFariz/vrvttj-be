<?php

namespace Database\Seeders;

use App\Models\DanceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DanceType::insert([
            ['name' => 'Putera Tunggal'],
            ['name' => 'Putera Tunggal dan Kelompok'],
            ['name' => 'Puteri Tunggal dan Kelompok'],
            ['name' => 'Puteri Kelompok'],
            ['name' => 'Duet Berpasangan'],
        ]);
    }
}

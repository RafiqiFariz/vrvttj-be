<?php

namespace Database\Seeders;

use App\Models\DancePart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DancePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DancePart::insert([
            ['name' => 'Pembukaan'],
            ['name' => 'Inti'],
            ['name' => 'Penutup'],
        ]);
    }
}

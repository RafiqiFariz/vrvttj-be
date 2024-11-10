<?php

namespace Database\Seeders;

use App\Models\Dance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dance::insert([
            [
                'name' => 'Tari Golek Ayun-Ayun',
                'dance_type_id' => 3,
                'picture' => 'dances/golek-ayun-ayun.png',
                'description' => 'Tari Golek Ayun-Ayun sering dipentaskan untuk menyambut tamu kehormatan dan biasanya ditarikan oleh seorang penari, tetapi bisa juga hingga enam sampai delapan penari. Tari Golek Ayun-Ayun merupakan varian dari tari Golek yang berbentuk tari tunggal, namun dalam penyajian tari Golek Ayun-Ayun bisa juga ditarikan secara berkelompok dengan mengolah komposisi dan pola lantainya.',
            ],
        ]);
    }
}

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
            [
                'name' => 'Pembukaan',
                'picture' => 'dance_parts/pembukaan.png',
                'description' => 'Gerakan ini dilakukan di awal tarian sebagai bentuk penghormatan kepada penonton, Tuhan, dan alam semesta. Penari memulai dengan gerakan lembut yang menunjukkan sikap sopan dan rendah hati.

Ciri khas: Penari berdiri tegak dengan ekspresi ramah, Gerakan tangan dilipat di depan dada (posisi sembah), kemudian diayunkan ke bawah dengan perlahan, dan Kepala menunduk sedikit atau mengayun lembut (gerakan pacak gulu) mengikuti irama musik gamelan yang pelan.

Makna: Sebagai bentuk doa dan penghormatan, menandakan kesiapan penari untuk memulai tarian.'
            ],
            [
                'name' => 'Inti',
                'picture' => 'dance_parts/inti.png',
                'description' => 'Gerakan inti menggambarkan keindahan dan keluwesan perempuan Jawa. Gerakan ini lebih dinamis dibandingkan pembukaan, dengan variasi langkah kaki, ayunan sampur, dan ekspresi anggun.

Makna: Menggambarkan keseharian perempuan Jawa, termasuk sisi lembut, anggun, dan penuh keindahan.',
            ],
            [
                'name' => 'Penutup',
                'picture' => 'dance_parts/penutup.png',
                'description' => 'Gerakan ini dilakukan di akhir tarian untuk menutup dengan elegan dan meninggalkan kesan mendalam bagi penonton. Irama musik gamelan biasanya melambat saat gerakan ini berlangsung.

Makna: Sebagai simbol ucapan terima kasih kepada penonton dan Tuhan atas kelancaran pementasan.'
            ],
        ]);
    }
}

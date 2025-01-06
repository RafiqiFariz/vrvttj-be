<?php

namespace Database\Seeders;

use App\Models\DanceMove;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DanceMoveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DanceMove::insert([
            [
                'dance_id' => 1,
                'dance_part_id' => 1,
                'name' => 'Ngithing',
                'picture' => 'dance_moves/ngithing.png',
                'description' => 'Dalam tari Jawa klasik adalah salah satu gerakan tangan yang sangat halus dan elegan, yang menggambarkan keanggunan dan ketelitian. Gerak ini sering digunakan sebagai ornamen dalam berbagai rangkaian gerakan tari, khususnya dalam tari-tari keraton seperti Bedhaya dan Serimpi.'
            ],
            [
                'dance_id' => 1,
                'dance_part_id' => 1,
                'name' => 'Ngrayung',
                'picture' => 'dance_moves/ngrayung.png',
                'description' => 'Salah satu gerakan tangan yang khas dalam tari Jawa klasik, di mana kedua tangan digerakkan secara simetris untuk membentuk posisi tangan yang indah dan serasi. Gerakan ini sering digunakan untuk mempertegas keanggunan dan keharmonisan dalam tarian, serta menambah variasi gerak yang memperkaya ekspresi tarian.'
            ],
            [
                'dance_id' => 1,
                'dance_part_id' => 1,
                'name' => 'Srisig',
                'picture' => 'dance_moves/srisig.png',
                'description' => 'Gerak Srisig salah satu gerakan dasar dalam tari Jawa klasik yang menampilkan ketangkasan dan kelincahan penari. Srisig melibatkan gerakan kaki yang cepat dan berulang dari satu sisi ke sisi lain, sambil menjaga keseimbangan dan keluwesan tubuh.'
            ],
            [
                'dance_id' => 1,
                'dance_part_id' => 1,
                'name' => 'Lontang Kanan dan Lontang Kiri',
                'picture' => 'dance_moves/lontang_kanan_kiri.png',
                'description' => 'Gerakan Lontang Kanan dan Lontang Kiri dalam tari klasik seperti Tari Golek Ayun-ayun adalah gerakan dasar yang menonjolkan keanggunan tubuh dengan meliukkan badan ke kanan dan kiri. Gerakan ini dilakukan dengan lembut dan luwes, mencerminkan ciri khas tarian keraton yang penuh dengan kesopanan dan kelembutan.'
            ],
            [
                'dance_id' => 1,
                'dance_part_id' => 1,
                'name' => 'Ukel',
                'picture' => 'dance_moves/ukel_dalam_luar.png',
                'description' => 'Ukel adalah gerakan dasar yang sangat khas dalam tari tradisional Jawa, termasuk Tari Golek Ayun-ayun. Gerakan ini menitikberatkan pada pergelangan tangan, yang diputar secara lembut dan halus. Ukel sering digunakan untuk memberikan sentuhan keanggunan dalam gerakan tangan penari, memperlihatkan keluwesan dan kelembutan yang merupakan ciri khas dari tari klasik keraton.'
            ],
            [
                'dance_id' => 1,
                'dance_part_id' => 1,
                'name' => 'Sembahan',
                'picture' => 'dance_moves/sembahan.png',
                'description' => 'Tangan: Kedua tangan secara perlahan diangkat ke arah dada dengan gerakan yang halus dan terkendali. Telapak tangan menghadap satu sama lain, dan jari-jari rapat tetapi tetap dalam posisi rileks.

                Posisi Tangan: Tangan berhenti di depan dada, dengan ibu jari menyentuh bagian tengah dada atau berada sedikit di bawah dagu. Telapak tangan menyatu dalam posisi sembah (namaste) dengan sudut siku yang membentuk segitiga.

                Pandangan: Tatapan mata sedikit menunduk ke arah tangan, mengekspresikan rasa hormat dan khidmat.'
            ],
        ]);
    }
}

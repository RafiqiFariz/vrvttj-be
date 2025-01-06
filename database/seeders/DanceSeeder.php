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
                'picture' => 'dances/tari_golek_ayun_ayun.png',
                'description' => 'Tari Golek Ayun-Ayun sering dipentaskan untuk menyambut tamu kehormatan dan biasanya ditarikan oleh seorang penari, tetapi bisa juga hingga enam sampai delapan penari. Tari Golek Ayun-Ayun merupakan varian dari tari Golek yang berbentuk tari tunggal, namun dalam penyajian tari Golek Ayun-Ayun bisa juga ditarikan secara berkelompok dengan mengolah komposisi dan pola lantainya.',
            ],
            [
                'name' => 'Tari Prawiroguno',
                'dance_type_id' => 1,
                'picture' => 'dances/tari_prawiro_guno.jpg',
                'description' => 'Tari ini bertema heroik dan kepahlawanan, menceritakan kisah tentang suasana perang antara rakyat Indonesia dan penjajah di mana dalam hal ini penjajah sudah mengalami kemunduran dan akan dikalahkan. Tari Prawiroguno yang berasal dari Jawa Tengah ini menggambarkan situasi kondisi peperangan di masa penjajahan. Aksi dan gerakan tari Prawiroguno sangat dinamis dengan penari yang berpakaian layaknya tengah dalam perang lengkap dengan properti seperti Tameng atau Tombak.',
            ],
            [
                'name' => 'Tari Kuda-Kuda',
                'dance_type_id' => 2,
                'picture' => 'dances/tari_kuda_kuda.jpg',
                'description' => 'Tari Kuda-kuda, adalah tari yang terinspirasi dari seorang joki yang menunggang kuda. Gerak dasar tari ini mengacu pada tari gaya Yogyakarta yang telah dikembangkan menjadi tarian simbolik naik kuda. Ragam ragam yang muncul pun masih seputar tari klasik kategori gagah.',
            ],
            [
                'name' => 'Tari Serimpi',
                'dance_type_id' => 4,
                'picture' => 'dances/tari_serimpi.jpg',
                'description' => 'Tarian ini dikenal dengan pola gerakan yang lembut seakan menggambarkan karakter Wanita Jawa yang lemah lembut. Tari Serimpi pada jaman dahulu menjadi media untuk menyampaikan bentuk perlawanan dan penolakan terhadap penjajah. Selain itu, beberapa jenis tari Serimpi merupakan tarian sacral di Istana.',
            ],
            [
                'name' => 'Tari Klana Raja',
                'dance_type_id' => 1,
                'picture' => 'dances/tari_klana_raja.jpg',
                'description' => 'Tari Klana Raja merupakan suatu penggambaran keagungan dan kegagahan seorang raja, dengan gaya tari Yogyakarta putera gagah. Disebut Klana Raja karena figur Raja adalah manifestasi penguasa yang besar, dan memiliki cita-cita tinggi',
            ],
            [
                'name' => 'Tari Klana Topeng',
                'dance_type_id' => 1,
                'picture' => 'dances/tari_klana_topeng.jpg',
                'description' => 'Tari Klana Topeng adalah jenis tarian Klana Topeng yang berkembang di lingkungan Keraton Ngayogyakarta Hadiningrat. Tarian ini menggambarkan raja Klana Sewanada dari Ponorogo. Tari Klana Sewandana menjadi jajararan tari klasik yang wajib ada di kraton Mataram sebagai penghormatan kepada Ponorogo yang telah membantu kraton Yogyakarta ketika diserang oleh Trunojoyo. Selain itu, Tari ini menunjukkan kegigihan dan kegagahan raja Klana Sewandana yang tangguh serta sebagai tari tolak bala.',
            ],
            [
                'name' => 'Tari Gambyong',
                'dance_type_id' => 3,
                'picture' => 'dances/tari_gambyong.jpg',
                'description' => 'Tari Gambyong merupakan salah satu bentuk tarian Jawa klasik yang berasal dari wilayah Surakarta dan biasanya dibawakan untuk pertunjukan atau menyambut tamu. Tari Gambyong yang paling dikenal adalah Tari Gambyong Pareanom dan Tari Gambyong Pangkur. Meskipun banyak macamnya, tarian ini memiliki dasar gerakan yang sama, yaitu gerakan tarian tayub/tlèdhèk.',
            ],
            [
                'name' => 'Tari Karonsih',
                'dance_type_id' => 6,
                'picture' => 'dances/tari_karonsih.jpg',
                'description' => 'Bercerita tentang Panji Asmara Bangun yang harus meninggalkan kraton, kepergian tanpa pamit ini membuat Dewi Sekartaji menjadi gelisah. Sebagai seorang istri, ia merasa kehilangan akan belahan jiwanya Dewi Sekartaji berusaha mencari keberadaan Panji Asmara Bangun. Sekartaji menunggu dan terus menunggu kedatangan sang suami dan berdoa kepada Sang Kuasa, agar tidak terjadi sesuatu kepada suaminya. Tanpa disadari sang pujaan hati datang menghampiri dan pada akhirnya Dewi Sekartaji gembira dan bahagia bersama suaminya tercinta.',
            ],
            [
                'name' => 'Tari Klana Alus',
                'dance_type_id' => 1,
                'picture' => 'dances/tari_klana_alus.jpg',
                'description' => 'Tari Klana Alus merupakan tari tunggal yang tercipta di lingkungan istana dan ditampilkan dalam sebuah pertunjukan. Tarian ini ditampilkan oleh seorang pria dengan gerakan yang lunak dan lamban. Makna yang disampaikan dari tari ini menceritakan seorang kesatria yang sedang jatuh cinta. Tokoh yang diperankan dalam tariannya adalah Prabu Jangkung Mardeya. Tariannya mengisahkan kisah Prabu Jangkung Mardeya yang tergila-gila pada putri kerabat Pandawa. Selain itu dapat juga sebagai Prabu Sri Suwela yang merupakan penyamaran Dewi Arimbi dalam figur pria.',
            ],
            [
                'name' => 'Tari Prawiro Watang',
                'dance_type_id' => 1,
                'picture' => 'dances/tari_prawiro_watang.jpg',
                'description' => 'Tari ini termasuk dalam genre tari keprajuritan yang menggambarkan kegagahan dan kecakapan gerak seorang prajurit. Tari Prawira Watang memiliki beberapa hal yang menarik selain gerakan tari banyak diambil dari gerakan silat tari ini juga menggunakan properti watang (bambu panjang). Penggunaan properti watang menjadikan tarian ini memiliki tingkat kesulitan tersendiri bagi penarinya.',
            ],
            [
                'name' => 'Tari Beksan Bandabaya',
                'dance_type_id' => 5,
                'picture' => 'dances/tari_beksan_bandabaya.jpg',
                'description' => 'Beksan Bandabaya adalah beksan yang populer di istana Pura Pakualaman Yogyakarta. Beksan ini menggambarkan para prajurit yang sedang berlatih olah senjata dengan menggunakan pedang dan tameng. Beksan ini ditarikan secara berkelompok, biasanya ditampilkan oleh empat orang penari.',
            ],
            [
                'name' => 'Tari Beksan Lawung Ageng',
                'dance_type_id' => 5,
                'picture' => 'dances/tari_beksan_lawung_ageng.png',
                'description' => 'Tari Beksan Lawung Ageng adalah tarian pusaka yang dimiliki Keraton Yogyakarta yang menggambarkan kegiatan adu ketangkasan antarprajurit bertombak. Tarian ini dibuat oleh Sri Sultan Hamengku Buwono I dengan inspirasi yang datang dari perlombaan watangan, yaitu latihan ketangkasan berkuda menggunakan tombak yang bisa dilakukan oleh abdi dalem prajurit pada masa itu. Beksan Lawung Ageng memiliki gerakan dengan   unsur heroik, patriotik, dan berkarakter maskulin. Terdapat dialog dalam tariannya yang menggunakan campuran bahasa Madura, Melayu, dan Jawa.',
            ],
        ]);
    }
}

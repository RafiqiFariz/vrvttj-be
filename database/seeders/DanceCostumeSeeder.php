<?php

namespace Database\Seeders;

use App\Models\DanceCostume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DanceCostumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DanceCostume::insert([
            [
                'dance_id' => 1,
                'name' => 'Sinyong',
                'picture' => 'dance_costumes/pictures/sinyong.png',
                'asset_path' => 'dance_costumes/assets/sinyong.fbx',
                'description' => 'Digunakan di dalam rambut yang berfungsi sebagai sanggul.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Pethat',
                'picture' => 'dance_costumes/pictures/pethat.png',
                'asset_path' => 'dance_costumes/assets/pethat.fbx',
                'description' => 'Digunakan sebagai aksesori di kepala.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Cunduk Mentul',
                'picture' => 'dance_costumes/pictures/cunduk_mentul.png',
                'asset_path' => 'dance_costumes/assets/cunduk_mentul.fbx',
                'description' => 'Digunakan sebagai aksesori di kepala.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Godhek',
                'picture' => 'dance_costumes/pictures/godhek.png',
                'asset_path' => 'dance_costumes/assets/godhek.fbx',
                'description' => 'Baju tari Bali yang digunakan untuk menari tari Bali.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Ceplok Jebehan',
                'picture' => 'dance_costumes/pictures/ceplok_jebehan.png',
                'asset_path' => 'dance_costumes/assets/ceplok_jebehan.fbx',
                'description' => 'Aksesori berbentuk bunga yang digunakan di kepala, dipasang di samping dan belakang sinyong.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Pelik',
                'picture' => 'dance_costumes/pictures/pelik.png',
                'asset_path' => 'dance_costumes/assets/pelik.fbx',
                'description' => 'Aksesori berbentuk bunga putih kecil yang digunakan sebagai penghias sinyong.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Jamang',
                'picture' => 'dance_costumes/pictures/jamang.png',
                'asset_path' => 'dance_costumes/assets/jamang.fbx',
                'description' => 'Digunakan sebagai penghias kepala yang terbuat dari kulit dan bulu.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Sumping Oncen',
                'picture' => 'dance_costumes/pictures/sumping_oncen.png',
                'asset_path' => 'dance_costumes/assets/sumping_oncen.fbx',
                'description' => 'Aksesori yang terbuat dari bahan kulit, digunakan di telinga kanan dan kiri.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Gelang',
                'picture' => 'dance_costumes/pictures/gelang.png',
                'asset_path' => 'dance_costumes/assets/gelang.fbx',
                'description' => 'Aksesori yang terbuat dari logam digunakan di tangan kanan dan kiri.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Klat Bahu Naga',
                'picture' => 'dance_costumes/pictures/klat_bahu_naga.png',
                'asset_path' => 'dance_costumes/assets/klat_bahu_naga.fbx',
                'description' => 'Aksesori dari kulit yang digunakan digunakan di bagian lengan atas kanan dan kiri.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Kalung Susun',
                'picture' => 'dance_costumes/pictures/kalung_susun.png',
                'asset_path' => 'dance_costumes/assets/kalung_susun.fbx',
                'description' => 'Digunakan sebagai aksesori di depan dada.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Slepe',
                'picture' => 'dance_costumes/pictures/slepe.png',
                'asset_path' => 'dance_costumes/assets/slepe.fbx',
                'description' => 'Aksesori yang terbuat dari kulit digunakan sebagai ikat pinggang.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Sampur Cinde',
                'picture' => 'dance_costumes/pictures/sampur_cinde.png',
                'asset_path' => 'dance_costumes/assets/sampur_cinde.fbx',
                'description' => 'Sebagai properti tari yang digunakan melingkar di pinggang.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Parang Gendreh Gurdha',
                'picture' => 'dance_costumes/pictures/parang_gendreh_gurdha.png',
                'asset_path' => 'dance_costumes/assets/parang_gendreh_gurdha.fbx',
                'description' => 'Kain sebagai penutup bagian bawah.'
            ],
            [
                'dance_id' => 1,
                'name' => 'Rompi Bludru',
                'picture' => 'dance_costumes/pictures/rompi_bludru.png',
                'asset_path' => 'dance_costumes/assets/rompi_bludru.fbx',
                'description' => 'Digunakan sebagai pakaian penutup badan.'
            ],
        ]);
    }
}

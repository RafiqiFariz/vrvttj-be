<?php

namespace Database\Seeders;

use App\Models\DancePartVideo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DancePartVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DancePartVideo::insert([
            [
                'dance_part_id' => 1,
                'thumbnail_path' => 'dance_parts/thumbnails/awal-1.png',
                'video_path' => 'dance_parts/videos/gerakan-awal-1-4-close-up.mp4',
                'description' => 'Gerakan awal bagian 1-4'
            ],
            [
                'dance_part_id' => 1,
                'thumbnail_path' => 'dance_parts/thumbnails/awal-2.png',
                'video_path' => 'dance_parts/videos/gerakan-awal-5-6-close-up.mp4',
                'description' => 'Gerakan awal bagian 5-6',
            ],
            [
                'dance_part_id' => 2,
                'thumbnail_path' => 'dance_parts/thumbnails/inti-1.png',
                'video_path' => 'dance_parts/videos/gerakan-inti-7-9-close-up.mp4',
                'description' => 'Gerakan inti bagian 7-9'
            ],
            [
                'dance_part_id' => 2,
                'thumbnail_path' => 'dance_parts/thumbnails/inti-2.png',
                'video_path' => 'dance_parts/videos/gerakan-inti-10-13-close-up.mp4',
                'description' => 'Gerakan inti bagian 10-13'
            ],
            [
                'dance_part_id' => 3,
                'thumbnail_path' => 'dance_parts/thumbnails/akhir-1.png',
                'video_path' => 'dance_parts/videos/gerakan-inti-dan-akhir-16-18-close-up.mp4',
                'description' => 'Gerakan inti dan akhir bagian 16-18'
            ],
            [
                'dance_part_id' => 3,
                'thumbnail_path' => 'dance_parts/thumbnails/akhir-2.png',
                'video_path' => 'dance_parts/videos/gerakan-akhir-18-ditutup-dgn-sembahan-sila.mp4',
                'description' => 'Gerakan akhir bagian 18 ditutup dengan sembahan sila'
            ]
        ]);
    }
}

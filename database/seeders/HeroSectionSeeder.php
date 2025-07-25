<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        HeroSection::create([
            'title' => 'Fakultas Teknologi Informasi Terdepan',
            'subtitle' => 'Membangun masa depan digital bersama teknologi terdepan dan pendidikan berkualitas tinggi',
            'background_video_url' => 'https://sample-videos.com/zip/10/mp4/SampleVideo_1280x720_2mb.mp4',
            'explanation_video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'background_image_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&h=1080&fit=crop',
            'is_active' => true,
        ]);
    }
}

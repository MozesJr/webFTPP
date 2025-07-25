<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsCategory;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Akademik', 'slug' => 'akademik', 'description' => 'Berita seputar kegiatan akademik', 'color' => '#3B82F6'],
            ['name' => 'Penelitian', 'slug' => 'penelitian', 'description' => 'Berita tentang penelitian dan publikasi', 'color' => '#10B981'],
            ['name' => 'Kemahasiswaan', 'slug' => 'kemahasiswaan', 'description' => 'Kegiatan dan prestasi mahasiswa', 'color' => '#F59E0B'],
            ['name' => 'Kerjasama', 'slug' => 'kerjasama', 'description' => 'Kerjasama dengan industri dan institusi', 'color' => '#8B5CF6'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'description' => 'Prestasi civitas akademika', 'color' => '#EF4444'],
            ['name' => 'Event', 'slug' => 'event', 'description' => 'Acara dan kegiatan fakultas', 'color' => '#06B6D4'],
        ];

        foreach ($categories as $category) {
            NewsCategory::create(array_merge($category, ['is_active' => true]));
        }
    }
}

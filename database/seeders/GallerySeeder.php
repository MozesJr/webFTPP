<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\ProgramStudi;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $programStudis = ProgramStudi::all();

        $galleries = [
            [
                'title' => 'Wisuda Sarjana Teknik Informatika 2024',
                'image_url' => 'https://picsum.photos/800/600?random=50',
                'caption' => 'Acara wisuda sarjana periode I tahun 2024 yang dihadiri oleh 150 lulusan',
                'category' => 'wisuda',
                'prodi' => 'TIF',
                'event_date' => '2024-03-15',
            ],
            [
                'title' => 'Laboratorium Programming Baru',
                'image_url' => 'https://picsum.photos/800/600?random=51',
                'caption' => 'Fasilitas laboratorium programming dengan 50 komputer terbaru',
                'category' => 'fasilitas',
                'prodi' => null,
                'event_date' => '2024-02-01',
            ],
            [
                'title' => 'Seminar Teknologi AI dan Machine Learning',
                'image_url' => 'https://picsum.photos/800/600?random=52',
                'caption' => 'Seminar nasional tentang perkembangan AI yang dihadiri 300 peserta',
                'category' => 'seminar',
                'prodi' => null,
                'event_date' => '2024-01-20',
            ],
            [
                'title' => 'Praktikum Database Management',
                'image_url' => 'https://picsum.photos/800/600?random=53',
                'caption' => 'Mahasiswa Sistem Informasi sedang praktikum database management',
                'category' => 'akademik',
                'prodi' => 'SIF',
                'event_date' => '2024-01-10',
            ],
            [
                'title' => 'Kunjungan Industri ke Google Indonesia',
                'image_url' => 'https://picsum.photos/800/600?random=54',
                'caption' => 'Mahasiswa mengunjungi kantor Google Indonesia untuk industrial visit',
                'category' => 'kunjungan',
                'prodi' => 'TIF',
                'event_date' => '2023-12-15',
            ],
            [
                'title' => 'Hackathon FTI 2023',
                'image_url' => 'https://picsum.photos/800/600?random=55',
                'caption' => 'Kompetisi hackathon internal yang diikuti 20 tim mahasiswa',
                'category' => 'kompetisi',
                'prodi' => null,
                'event_date' => '2023-11-25',
            ],
            [
                'title' => 'Pameran Tugas Akhir Mahasiswa',
                'image_url' => 'https://picsum.photos/800/600?random=56',
                'caption' => 'Pameran hasil tugas akhir mahasiswa semester genap 2023',
                'category' => 'pameran',
                'prodi' => null,
                'event_date' => '2023-11-10',
            ],
            [
                'title' => 'Workshop Cloud Computing dengan AWS',
                'image_url' => 'https://picsum.photos/800/600?random=57',
                'caption' => 'Workshop praktis penggunaan Amazon Web Services untuk mahasiswa',
                'category' => 'workshop',
                'prodi' => 'TI',
                'event_date' => '2023-10-20',
            ],
        ];

        foreach ($galleries as $index => $gallery) {
            $prodi = null;
            if ($gallery['prodi']) {
                $prodi = $programStudis->where('code', $gallery['prodi'])->first();
            }

            Gallery::create([
                'title' => $gallery['title'],
                'image_url' => $gallery['image_url'],
                'caption' => $gallery['caption'],
                'category' => $gallery['category'],
                'prodi_id' => $prodi?->id,
                'event_date' => $gallery['event_date'],
                'is_active' => true,
                'order_index' => $index + 1,
            ]);
        }

        // Generate additional gallery items
        for ($i = 0; $i < 15; $i++) {
            $prodi = rand(0, 3) > 0 ? $programStudis->random() : null;
            $categories = ['akademik', 'fasilitas', 'kegiatan', 'kompetisi', 'seminar'];

            Gallery::create([
                'title' => 'Kegiatan ' . ($i + 9) . ': ' . fake()->sentence(4),
                'image_url' => 'https://picsum.photos/800/600?random=' . ($i + 60),
                'caption' => fake()->paragraph(1),
                'category' => $categories[array_rand($categories)],
                'prodi_id' => $prodi?->id,
                'event_date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'is_active' => true,
                'order_index' => $i + 10,
            ]);
        }
    }
}

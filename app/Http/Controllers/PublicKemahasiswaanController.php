<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PublicKemahasiswaanController extends Controller
{
    public function index(): Response
    {
        // Data statis dummy untuk preview
        $statistics = [
            'total_students' => 1250,
            'active_students' => 1180,
            'graduate_students' => 70,
            'international_students' => 15,
        ];

        $studentOrganizations = [
            [
                'id' => 1,
                'name' => 'Himpunan Mahasiswa Teknik Perminyakan',
                'acronym' => 'HIMATEKPERM',
                'logo' => 'https://cdn.prod.website-files.com/66a1bd0282e5dc7d1c9f618c/66a1bd0282e5dc7d1c9f624f_Logo%20UNIPA2-01.webp',
                'description' => 'Organisasi mahasiswa yang menaungi seluruh mahasiswa Teknik Perminyakan UNIPA.',
                'contact_person' => 'John Doe',
                'contact_email' => 'himatekperm@unipa.ac.id',
            ],
            [
                'id' => 2,
                'name' => 'Himpunan Mahasiswa Teknik Pertambangan',
                'acronym' => 'HIMATEKBANG',
                'logo' => 'https://cdn.prod.website-files.com/66a1bd0282e5dc7d1c9f618c/66a1bd0282e5dc7d1c9f624f_Logo%20UNIPA2-01.webp',
                'description' => 'Wadah aspirasi dan kreativitas mahasiswa Teknik Pertambangan.',
                'contact_person' => 'Jane Smith',
                'contact_email' => 'himatekbang@unipa.ac.id',
            ],
            [
                'id' => 3,
                'name' => 'Himpunan Mahasiswa Teknik Geologi',
                'acronym' => 'HIMATEKGEO',
                'logo' => 'https://cdn.prod.website-files.com/66a1bd0282e5dc7d1c9f618c/66a1bd0282e5dc7d1c9f624f_Logo%20UNIPA2-01.webp',
                'description' => 'Organisasi yang mewadahi mahasiswa Teknik Geologi dalam mengembangkan potensi.',
                'contact_person' => 'Ahmad Yani',
                'contact_email' => 'himatekgeo@unipa.ac.id',
            ],
        ];

        $achievements = [
            [
                'id' => 1,
                'title' => 'Juara 1 Kompetisi Karya Tulis Ilmiah Nasional',
                'student_name' => 'Muhammad Rizki',
                'program_studi' => 'Teknik Perminyakan',
                'year' => 2024,
                'description' => 'Penelitian tentang Enhanced Oil Recovery menggunakan metode Chemical Flooding.',
                'image' => 'https://ugm.ac.id/wp-content/uploads/2022/09/07092216625148611062717428.jpeg',
            ],
            [
                'id' => 2,
                'title' => 'Juara 2 National Mining Competition',
                'student_name' => 'Siti Nurhaliza',
                'program_studi' => 'Teknik Pertambangan',
                'year' => 2024,
                'description' => 'Kompetisi desain tambang terbuka berkelanjutan.',
                'image' => 'https://cdn.antaranews.com/cache/1200x800/2022/05/30/juara-1-panning-Unja.jpeg',
            ],
            [
                'id' => 3,
                'title' => 'Best Paper Award - Geoscience Conference',
                'student_name' => 'Budi Santoso',
                'program_studi' => 'Teknik Geologi',
                'year' => 2023,
                'description' => 'Paper tentang analisis struktur geologi untuk eksplorasi mineral.',
                'image' => 'https://www.eri.u-tokyo.ac.jp/en/wp-content/uploads/sites/2/2022/01/HPCAsia-2022-Best-Paper-Award-Certificate-1024x771.jpg',
            ],
        ];

        $scholarships = [
            [
                'name' => 'Beasiswa Bidikmisi',
                'description' => 'Bantuan biaya pendidikan bagi mahasiswa berprestasi dari keluarga kurang mampu',
                'quota' => 50,
                'requirements' => ['IPK minimal 3.0', 'Tidak mampu secara ekonomi', 'Aktif organisasi'],
            ],
            [
                'name' => 'Beasiswa PPA',
                'description' => 'Peningkatan Prestasi Akademik untuk mahasiswa dengan IPK tinggi',
                'quota' => 30,
                'requirements' => ['IPK minimal 3.5', 'Mahasiswa aktif', 'Semester 3 keatas'],
            ],
            [
                'name' => 'Beasiswa Unggulan',
                'description' => 'Beasiswa prestasi untuk mahasiswa berprestasi akademik dan non-akademik',
                'quota' => 20,
                'requirements' => ['IPK minimal 3.7', 'Prestasi lomba tingkat nasional', 'Recommendation letter'],
            ],
        ];

        return Inertia::render('Public/Kemahasiswaan/Index', [
            'statistics' => $statistics,
            'organizations' => $studentOrganizations,
            'achievements' => $achievements,
            'scholarships' => $scholarships,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;
use App\Models\Feature;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Teknik Informatika',
                'code' => 'TIF',
                'degree_level' => 'S1',
                'description' => 'Program studi yang mempelajari pengembangan perangkat lunak, sistem informasi, dan teknologi komputer.',
                'overview' => '<p>Program Studi Teknik Informatika adalah program studi yang mempelajari dan menerapkan prinsip-prinsip ilmu komputer dan analisis matematis dalam perancangan, pengujian, pengembangan, dan evaluasi sistem operasi, perangkat lunak, dan kinerja komputer.</p>

<p>Lulusan program studi ini diharapkan mampu merancang, mengimplementasi, dan memelihara sistem perangkat lunak yang kompleks, serta memiliki kemampuan untuk beradaptasi dengan perkembangan teknologi yang cepat.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?w=800&h=600&fit=crop',
                'accreditation' => 'A',
                'accreditation_date' => '2020-01-15',
                'accreditation_expire' => '2025-01-15',
                'head_of_program' => 'Dr. Budi Santoso, M.Kom.',
                'established_year' => 1995,
                'is_active' => true,
                'features' => [
                    ['title' => 'Laboratorium Modern', 'description' => 'Dilengkapi dengan perangkat komputer terbaru dan software development tools', 'icon' => 'computer-desktop'],
                    ['title' => 'Kurikulum Industri 4.0', 'description' => 'Kurikulum yang disesuaikan dengan kebutuhan industri digital', 'icon' => 'cog'],
                    ['title' => 'Sertifikasi Internasional', 'description' => 'Program sertifikasi dari vendor teknologi terkemuka', 'icon' => 'academic-cap'],
                ]
            ],
            [
                'name' => 'Sistem Informasi',
                'code' => 'SIF',
                'degree_level' => 'S1',
                'description' => 'Program studi yang fokus pada perancangan dan pengelolaan sistem informasi untuk mendukung proses bisnis.',
                'overview' => '<p>Program Studi Sistem Informasi menggabungkan bidang teknologi informasi dengan manajemen bisnis. Program ini mempersiapkan mahasiswa untuk menjadi profesional yang mampu menganalisis kebutuhan bisnis dan merancang solusi teknologi informasi yang tepat.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop',
                'accreditation' => 'A',
                'accreditation_date' => '2019-06-20',
                'accreditation_expire' => '2024-06-20',
                'head_of_program' => 'Dr. Sari Indrawati, M.SI.',
                'established_year' => 1998,
                'is_active' => true,
                'features' => [
                    ['title' => 'Business Intelligence Lab', 'description' => 'Laboratorium khusus untuk analisis data bisnis', 'icon' => 'chart-bar'],
                    ['title' => 'Enterprise Systems', 'description' => 'Pembelajaran sistem enterprise seperti SAP dan Oracle', 'icon' => 'building-office'],
                    ['title' => 'Project Management', 'description' => 'Pelatihan manajemen proyek IT dengan metodologi Agile', 'icon' => 'clipboard-document-list'],
                ]
            ],
            [
                'name' => 'Teknologi Informasi',
                'code' => 'TI',
                'degree_level' => 'D3',
                'description' => 'Program diploma yang fokus pada implementasi dan maintenance teknologi informasi.',
                'overview' => '<p>Program Diploma III Teknologi Informasi adalah program vokasi yang menekankan pada keterampilan praktis dalam bidang teknologi informasi. Program ini mempersiapkan tenaga ahli madya yang siap kerja di industri.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=800&h=600&fit=crop',
                'accreditation' => 'B',
                'accreditation_date' => '2021-03-10',
                'accreditation_expire' => '2026-03-10',
                'head_of_program' => 'Ir. Ahmad Fauzi, M.T.',
                'established_year' => 2005,
                'is_active' => true,
                'features' => [
                    ['title' => 'Praktikum Intensif', 'description' => '70% praktikum dan 30% teori untuk kesiapan kerja', 'icon' => 'wrench-screwdriver'],
                    ['title' => 'Magang Industri', 'description' => 'Program magang wajib di perusahaan teknologi', 'icon' => 'building-office-2'],
                    ['title' => 'Sertifikasi Vendor', 'description' => 'Pelatihan sertifikasi Cisco, Microsoft, dan lainnya', 'icon' => 'shield-check'],
                ]
            ],
            [
                'name' => 'Magister Teknik Informatika',
                'code' => 'MTI',
                'degree_level' => 'S2',
                'description' => 'Program magister untuk pengembangan keahlian lanjutan di bidang teknik informatika.',
                'overview' => '<p>Program Magister Teknik Informatika dirancang untuk menghasilkan lulusan yang memiliki kemampuan penelitian dan pengembangan di bidang teknologi informasi tingkat lanjut.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop',
                'accreditation' => 'B',
                'accreditation_date' => '2020-09-15',
                'accreditation_expire' => '2025-09-15',
                'head_of_program' => 'Prof. Dr. Hendro Wicaksono, M.Sc.',
                'established_year' => 2010,
                'is_active' => true,
                'features' => [
                    ['title' => 'Riset Terdepan', 'description' => 'Fokus pada penelitian AI, IoT, dan teknologi emerging', 'icon' => 'beaker'],
                    ['title' => 'Publikasi Internasional', 'description' => 'Target publikasi di jurnal internasional bereputasi', 'icon' => 'document-text'],
                    ['title' => 'Kolaborasi Industri', 'description' => 'Riset bersama dengan perusahaan teknologi global', 'icon' => 'users'],
                ]
            ]
        ];

        foreach ($programs as $programData) {
            $features = $programData['features'];
            unset($programData['features']);

            $program = ProgramStudi::create($programData);

            foreach ($features as $index => $featureData) {
                Feature::create([
                    'prodi_id' => $program->id,
                    'title' => $featureData['title'],
                    'description' => $featureData['description'],
                    'icon' => $featureData['icon'],
                    'is_active' => true,
                    'order_index' => $index + 1,
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Laboratorium Teknologi Pangan',
                'description' => 'Laboratorium lengkap untuk praktikum teknologi pangan dengan peralatan modern dan standar industri. Dilengkapi dengan berbagai instrumen analisis kimia, mikrobiologi, dan pengujian sensori.',
                'short_description' => 'Lab modern untuk praktikum teknologi pangan',
                'image' => 'facilities/lab-pangan.jpg',
                'location' => 'Gedung A, Lantai 2',
                'capacity' => '40 mahasiswa',
                'area' => '150 m²',
                'features' => [
                    'Peralatan analisis kimia lengkap',
                    'Inkubator mikrobiologi',
                    'Alat pengujian sensori',
                    'AC dan ventilasi baik',
                    'Safety equipment lengkap'
                ],
                'contact_person' => 'Dr. Ahmad Fauzi',
                'contact_phone' => '0274-1234567',
                'contact_email' => 'labpangan@unipa.ac.id',
                'is_available' => true,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Perpustakaan Fakultas',
                'description' => 'Perpustakaan fakultas dengan koleksi buku, jurnal, dan referensi terkini di bidang teknologi pertanian dan pangan. Menyediakan ruang baca yang nyaman dengan akses internet gratis.',
                'short_description' => 'Perpustakaan dengan koleksi lengkap',
                'image' => 'facilities/perpustakaan.jpg',
                'location' => 'Gedung B, Lantai 1',
                'capacity' => '100 orang',
                'area' => '300 m²',
                'features' => [
                    'Koleksi buku 5000+ judul',
                    'Akses jurnal internasional',
                    'WiFi gratis',
                    'Ruang baca ber-AC',
                    'Area diskusi kelompok'
                ],
                'contact_person' => 'Dra. Siti Nurjanah',
                'contact_phone' => '0274-1234568',
                'contact_email' => 'perpus@unipa.ac.id',
                'is_available' => true,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Greenhouse',
                'description' => 'Greenhouse untuk penelitian dan praktikum budidaya tanaman dengan sistem kontrol iklim otomatis. Cocok untuk penelitian pertanian dan hortikultura.',
                'short_description' => 'Fasilitas budidaya tanaman modern',
                'image' => 'facilities/greenhouse.jpg',
                'location' => 'Area Belakang Kampus',
                'capacity' => '30 mahasiswa',
                'area' => '500 m²',
                'features' => [
                    'Sistem irigasi otomatis',
                    'Kontrol suhu dan kelembaban',
                    'Media tanam steril',
                    'Sistem pencahayaan',
                    'Area pembibitan'
                ],
                'contact_person' => 'Ir. Budi Santoso, M.Si',
                'contact_phone' => '0274-1234569',
                'contact_email' => 'greenhouse@unipa.ac.id',
                'is_available' => true,
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Aula Serbaguna',
                'description' => 'Ruang aula yang dapat digunakan untuk berbagai kegiatan seperti seminar, workshop, wisuda, dan acara kemahasiswaan lainnya. Dilengkapi dengan sound system dan proyektor.',
                'short_description' => 'Aula untuk berbagai acara',
                'image' => 'facilities/aula.jpg',
                'location' => 'Gedung C, Lantai 1',
                'capacity' => '500 orang',
                'area' => '600 m²',
                'features' => [
                    'Sound system profesional',
                    'Proyektor HD',
                    'AC central',
                    'Panggung dan backdrop',
                    'Kursi auditorium'
                ],
                'contact_person' => 'Drs. Eko Prasetyo',
                'contact_phone' => '0274-1234570',
                'contact_email' => 'aula@unipa.ac.id',
                'is_available' => true,
                'is_active' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}

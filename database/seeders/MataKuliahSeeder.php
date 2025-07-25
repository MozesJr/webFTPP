<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;
use App\Models\Kurikulum;
use App\Models\ProgramStudi;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $kurikulums = Kurikulum::where('is_active', true)->get();

        foreach ($kurikulums as $kurikulum) {
            $prodi = $kurikulum->programStudi;

            if ($prodi->code === 'TIF') {
                $this->createTeknikInformatikaCourses($kurikulum);
            } elseif ($prodi->code === 'SIF') {
                $this->createSistemInformasiCourses($kurikulum);
            } elseif ($prodi->code === 'TI') {
                $this->createTeknologiInformasiCourses($kurikulum);
            } elseif ($prodi->code === 'MTI') {
                $this->createMagisterTeknikInformatikaCourses($kurikulum);
            }
        }
    }

    private function createTeknikInformatikaCourses($kurikulum)
    {
        $courses = [
            // Semester 1
            [
                'code' => 'TIF101',
                'name' => 'Algoritma dan Pemrograman I',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Mata kuliah ini memperkenalkan konsep dasar algoritma dan pemrograman menggunakan bahasa pemrograman C++. Mahasiswa akan mempelajari struktur program, tipe data, operator, kontrol alur, fungsi, dan array.',
                'learning_outcomes' => 'Setelah mengikuti mata kuliah ini, mahasiswa mampu: 1) Memahami konsep dasar algoritma, 2) Menulis program sederhana dalam bahasa C++, 3) Menggunakan struktur kontrol dan fungsi'
            ],
            [
                'code' => 'TIF102',
                'name' => 'Matematika Diskrit',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Mata kuliah ini membahas konsep-konsep matematika yang mendasari ilmu komputer, meliputi logika, himpunan, relasi, fungsi, graf, dan kombinatorika.',
                'learning_outcomes' => 'Mahasiswa mampu menerapkan konsep matematika diskrit dalam pemecahan masalah komputasi dan memahami dasar-dasar theoretical computer science'
            ],
            [
                'code' => 'TIF103',
                'name' => 'Sistem Digital',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Mata kuliah yang membahas dasar-dasar sistem digital, sistem bilangan, gerbang logika, rangkaian kombinasional dan sekuensial, serta pengenalan mikroprosesor.',
                'learning_outcomes' => 'Mahasiswa memahami prinsip kerja sistem digital dan mampu merancang rangkaian digital sederhana'
            ],
            [
                'code' => 'TIF104',
                'name' => 'Pengantar Teknologi Informasi',
                'credits' => 2,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Pengenalan konsep dasar teknologi informasi, sejarah perkembangan komputer, komponen sistem komputer, dan aplikasi teknologi informasi dalam berbagai bidang.',
                'learning_outcomes' => 'Mahasiswa memahami konsep dasar teknologi informasi dan perkembangannya serta dapat mengidentifikasi aplikasi TI dalam berbagai domain'
            ],
            [
                'code' => 'UNI101',
                'name' => 'Bahasa Indonesia',
                'credits' => 2,
                'semester' => 1,
                'category' => 'mkdu',
                'prerequisite' => null,
                'description' => 'Mata kuliah yang mengembangkan kemampuan berkomunikasi dalam bahasa Indonesia yang baik dan benar, baik lisan maupun tulisan.',
                'learning_outcomes' => 'Mahasiswa mampu berkomunikasi efektif dalam bahasa Indonesia untuk keperluan akademik dan profesional'
            ],
            [
                'code' => 'UNI102',
                'name' => 'Pancasila',
                'credits' => 2,
                'semester' => 1,
                'category' => 'mkdu',
                'prerequisite' => null,
                'description' => 'Pemahaman nilai-nilai Pancasila sebagai dasar negara dan ideologi bangsa Indonesia serta implementasinya dalam kehidupan bermasyarakat.',
                'learning_outcomes' => 'Mahasiswa memahami dan dapat mengimplementasikan nilai-nilai Pancasila dalam kehidupan sehari-hari'
            ],

            // Semester 2
            [
                'code' => 'TIF201',
                'name' => 'Algoritma dan Pemrograman II',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['TIF101'],
                'description' => 'Lanjutan dari Algoritma dan Pemrograman I, membahas konsep pemrograman lanjut seperti pointer, struktur data sederhana, file handling, dan pemrograman berorientasi objek dasar.',
                'learning_outcomes' => 'Mahasiswa mampu membuat program yang lebih kompleks dengan menggunakan konsep-konsep pemrograman lanjut'
            ],
            [
                'code' => 'TIF202',
                'name' => 'Struktur Data',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['TIF101'],
                'description' => 'Mata kuliah yang membahas berbagai struktur data seperti array, linked list, stack, queue, tree, dan graph beserta algoritma-algoritma yang berkaitan.',
                'learning_outcomes' => 'Mahasiswa mampu memilih dan mengimplementasikan struktur data yang tepat untuk menyelesaikan masalah pemrograman'
            ],
            [
                'code' => 'TIF203',
                'name' => 'Basis Data I',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Pengenalan konsep basis data, model data relasional, normalisasi, SQL, dan pengenalan sistem manajemen basis data.',
                'learning_outcomes' => 'Mahasiswa mampu merancang dan mengimplementasikan basis data relasional sederhana'
            ],
            [
                'code' => 'TIF204',
                'name' => 'Matematika Informatika',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['TIF102'],
                'description' => 'Mata kuliah yang membahas konsep matematika yang digunakan dalam informatika seperti aljabar linear, statistika, dan teori probabilitas.',
                'learning_outcomes' => 'Mahasiswa memahami dan dapat menerapkan konsep matematika dalam pemecahan masalah informatika'
            ],
            [
                'code' => 'UNI201',
                'name' => 'Bahasa Inggris',
                'credits' => 2,
                'semester' => 2,
                'category' => 'mkdu',
                'prerequisite' => null,
                'description' => 'Pengembangan kemampuan bahasa Inggris untuk keperluan akademik dan profesional, khususnya dalam bidang teknologi informasi.',
                'learning_outcomes' => 'Mahasiswa mampu berkomunikasi dalam bahasa Inggris untuk keperluan akademik dan profesional di bidang TI'
            ],

            // Semester 3
            [
                'code' => 'TIF301',
                'name' => 'Pemrograman Web',
                'credits' => 3,
                'semester' => 3,
                'category' => 'wajib',
                'prerequisite' => ['TIF201'],
                'description' => 'Mata kuliah yang membahas pengembangan aplikasi web menggunakan HTML, CSS, JavaScript, dan framework web modern.',
                'learning_outcomes' => 'Mahasiswa mampu membuat aplikasi web yang interaktif dan responsif'
            ],
            [
                'code' => 'TIF302',
                'name' => 'Basis Data II',
                'credits' => 3,
                'semester' => 3,
                'category' => 'wajib',
                'prerequisite' => ['TIF203'],
                'description' => 'Lanjutan dari Basis Data I, membahas konsep lanjut seperti indexing, query optimization, stored procedure, trigger, dan administrasi basis data.',
                'learning_outcomes' => 'Mahasiswa mampu merancang dan mengelola basis data yang kompleks dan efisien'
            ],
            [
                'code' => 'TIF303',
                'name' => 'Rekayasa Perangkat Lunak',
                'credits' => 3,
                'semester' => 3,
                'category' => 'wajib',
                'prerequisite' => ['TIF201'],
                'description' => 'Mata kuliah yang membahas metodologi pengembangan perangkat lunak, analisis kebutuhan, desain sistem, testing, dan maintenance.',
                'learning_outcomes' => 'Mahasiswa memahami dan dapat menerapkan prinsip-prinsip rekayasa perangkat lunak dalam pengembangan aplikasi'
            ],
            [
                'code' => 'TIF304',
                'name' => 'Jaringan Komputer',
                'credits' => 3,
                'semester' => 3,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Pengenalan konsep jaringan komputer, protokol komunikasi, arsitektur jaringan, dan teknologi jaringan terkini.',
                'learning_outcomes' => 'Mahasiswa memahami konsep jaringan komputer dan mampu merancang jaringan sederhana'
            ],
            [
                'code' => 'TIF305',
                'name' => 'Sistem Operasi',
                'credits' => 3,
                'semester' => 3,
                'category' => 'wajib',
                'prerequisite' => ['TIF103'],
                'description' => 'Mata kuliah yang membahas konsep dan prinsip sistem operasi, manajemen proses, memori, file system, dan keamanan sistem.',
                'learning_outcomes' => 'Mahasiswa memahami cara kerja sistem operasi dan dapat melakukan administrasi sistem operasi'
            ],

            // Semester 4
            [
                'code' => 'TIF401',
                'name' => 'Pemrograman Mobile',
                'credits' => 3,
                'semester' => 4,
                'category' => 'wajib',
                'prerequisite' => ['TIF301'],
                'description' => 'Pengembangan aplikasi mobile untuk platform Android dan iOS menggunakan teknologi native dan cross-platform.',
                'learning_outcomes' => 'Mahasiswa mampu membuat aplikasi mobile yang fungsional dan user-friendly'
            ],
            [
                'code' => 'TIF402',
                'name' => 'Kecerdasan Buatan',
                'credits' => 3,
                'semester' => 4,
                'category' => 'wajib',
                'prerequisite' => ['TIF202', 'TIF204'],
                'description' => 'Pengenalan konsep kecerdasan buatan, algoritma pencarian, machine learning, neural network, dan aplikasi AI.',
                'learning_outcomes' => 'Mahasiswa memahami konsep AI dan mampu mengimplementasikan algoritma AI sederhana'
            ],
            [
                'code' => 'TIF403',
                'name' => 'Keamanan Informasi',
                'credits' => 3,
                'semester' => 4,
                'category' => 'wajib',
                'prerequisite' => ['TIF304'],
                'description' => 'Mata kuliah yang membahas konsep keamanan informasi, kriptografi, security protocol, dan manajemen risiko keamanan.',
                'learning_outcomes' => 'Mahasiswa memahami ancaman keamanan informasi dan mampu menerapkan teknik pengamanan sistem'
            ],
            [
                'code' => 'TIF404',
                'name' => 'Interaksi Manusia dan Komputer',
                'credits' => 3,
                'semester' => 4,
                'category' => 'pilihan',
                'prerequisite' => ['TIF301'],
                'description' => 'Studi tentang interaksi antara manusia dan komputer, prinsip desain antarmuka, usability testing, dan user experience design.',
                'learning_outcomes' => 'Mahasiswa mampu merancang antarmuka yang user-friendly dan melakukan evaluasi usability'
            ],

            // Semester 5-8 (selected courses)
            [
                'code' => 'TIF501',
                'name' => 'Pembelajaran Mesin',
                'credits' => 3,
                'semester' => 5,
                'category' => 'pilihan',
                'prerequisite' => ['TIF402'],
                'description' => 'Mata kuliah lanjut tentang machine learning, deep learning, dan aplikasinya dalam berbagai domain.',
                'learning_outcomes' => 'Mahasiswa mampu mengimplementasikan algoritma machine learning untuk menyelesaikan masalah real-world'
            ],
            [
                'code' => 'TIF502',
                'name' => 'Big Data',
                'credits' => 3,
                'semester' => 5,
                'category' => 'pilihan',
                'prerequisite' => ['TIF302'],
                'description' => 'Pengenalan konsep big data, teknologi hadoop, spark, dan teknik analisis data skala besar.',
                'learning_outcomes' => 'Mahasiswa memahami teknologi big data dan mampu melakukan analisis data skala besar'
            ],
            [
                'code' => 'TIF801',
                'name' => 'Tugas Akhir',
                'credits' => 6,
                'semester' => 8,
                'category' => 'wajib',
                'prerequisite' => ['TIF303'],
                'description' => 'Proyek akhir mahasiswa berupa penelitian atau pengembangan sistem yang menerapkan ilmu yang telah dipelajari.',
                'learning_outcomes' => 'Mahasiswa mampu melakukan penelitian mandiri dan menghasilkan karya ilmiah yang berkualitas'
            ]
        ];

        foreach ($courses as $course) {
            MataKuliah::create([
                'kurikulum_id' => $kurikulum->id,
                'code' => $course['code'],
                'name' => $course['name'],
                'credits' => $course['credits'],
                'semester' => $course['semester'],
                'category' => $course['category'],
                'prerequisite' => $course['prerequisite'],
                'description' => $course['description'],
                'learning_outcomes' => $course['learning_outcomes'],
                'is_active' => true,
            ]);
        }
    }

    private function createSistemInformasiCourses($kurikulum)
    {
        $courses = [
            // Semester 1
            [
                'code' => 'SIF101',
                'name' => 'Pengantar Sistem Informasi',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Pengenalan konsep dasar sistem informasi, komponen sistem informasi, dan peran sistem informasi dalam organisasi.',
                'learning_outcomes' => 'Mahasiswa memahami konsep dasar sistem informasi dan dapat mengidentifikasi kebutuhan sistem informasi dalam organisasi'
            ],
            [
                'code' => 'SIF102',
                'name' => 'Algoritma dan Pemrograman',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Konsep dasar algoritma dan pemrograman menggunakan bahasa pemrograman modern untuk pemecahan masalah bisnis.',
                'learning_outcomes' => 'Mahasiswa mampu membuat program sederhana untuk menyelesaikan masalah bisnis'
            ],
            [
                'code' => 'SIF103',
                'name' => 'Matematika Bisnis',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Konsep matematika yang digunakan dalam analisis bisnis, termasuk fungsi, limit, turunan, dan aplikasinya.',
                'learning_outcomes' => 'Mahasiswa mampu menerapkan konsep matematika dalam analisis dan pemecahan masalah bisnis'
            ],
            [
                'code' => 'SIF104',
                'name' => 'Pengantar Manajemen',
                'credits' => 2,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Pengenalan konsep dasar manajemen, fungsi-fungsi manajemen, dan prinsip-prinsip organisasi.',
                'learning_outcomes' => 'Mahasiswa memahami konsep dasar manajemen dan dapat mengidentifikasi fungsi manajemen dalam organisasi'
            ],

            // Semester 2
            [
                'code' => 'SIF201',
                'name' => 'Basis Data',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['SIF102'],
                'description' => 'Konsep basis data, model data relasional, normalisasi, SQL, dan implementasi basis data untuk sistem informasi.',
                'learning_outcomes' => 'Mahasiswa mampu merancang dan mengimplementasikan basis data untuk sistem informasi bisnis'
            ],
            [
                'code' => 'SIF202',
                'name' => 'Analisis dan Perancangan Sistem',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['SIF101'],
                'description' => 'Metodologi analisis dan perancangan sistem informasi, teknik pemodelan sistem, dan dokumentasi sistem.',
                'learning_outcomes' => 'Mahasiswa mampu melakukan analisis kebutuhan dan merancang sistem informasi'
            ],
            [
                'code' => 'SIF203',
                'name' => 'Pemrograman Berorientasi Objek',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['SIF102'],
                'description' => 'Konsep pemrograman berorientasi objek, class, object, inheritance, polymorphism, dan implementasinya.',
                'learning_outcomes' => 'Mahasiswa mampu membuat program menggunakan paradigma pemrograman berorientasi objek'
            ],
            [
                'code' => 'SIF204',
                'name' => 'Statistika',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['SIF103'],
                'description' => 'Konsep statistika deskriptif dan inferensial, distribusi probabilitas, pengujian hipotesis, dan aplikasinya dalam bisnis.',
                'learning_outcomes' => 'Mahasiswa mampu melakukan analisis statistik untuk mendukung pengambilan keputusan bisnis'
            ],

            // Semester 3-8 (selected key courses)
            [
                'code' => 'SIF301',
                'name' => 'Sistem Informasi Manajemen',
                'credits' => 3,
                'semester' => 3,
                'category' => 'wajib',
                'prerequisite' => ['SIF202'],
                'description' => 'Konsep SIM, peran SI dalam mendukung fungsi manajemen, dan implementasi SIM dalam organisasi.',
                'learning_outcomes' => 'Mahasiswa memahami peran sistem informasi dalam mendukung manajemen organisasi'
            ],
            [
                'code' => 'SIF401',
                'name' => 'E-Business',
                'credits' => 3,
                'semester' => 4,
                'category' => 'wajib',
                'prerequisite' => ['SIF301'],
                'description' => 'Konsep e-business, e-commerce, model bisnis digital, dan implementasi teknologi dalam bisnis.',
                'learning_outcomes' => 'Mahasiswa memahami konsep e-business dan mampu merancang strategi bisnis digital'
            ],
            [
                'code' => 'SIF501',
                'name' => 'Business Intelligence',
                'credits' => 3,
                'semester' => 5,
                'category' => 'pilihan',
                'prerequisite' => ['SIF204', 'SIF201'],
                'description' => 'Konsep business intelligence, data warehouse, data mining, dan dashboard untuk mendukung pengambilan keputusan.',
                'learning_outcomes' => 'Mahasiswa mampu merancang dan mengimplementasikan sistem business intelligence'
            ],
            [
                'code' => 'SIF801',
                'name' => 'Tugas Akhir',
                'credits' => 6,
                'semester' => 8,
                'category' => 'wajib',
                'prerequisite' => ['SIF401'],
                'description' => 'Proyek akhir berupa penelitian atau pengembangan sistem informasi yang menerapkan ilmu yang telah dipelajari.',
                'learning_outcomes' => 'Mahasiswa mampu melakukan penelitian mandiri di bidang sistem informasi'
            ]
        ];

        foreach ($courses as $course) {
            MataKuliah::create([
                'kurikulum_id' => $kurikulum->id,
                'code' => $course['code'],
                'name' => $course['name'],
                'credits' => $course['credits'],
                'semester' => $course['semester'],
                'category' => $course['category'],
                'prerequisite' => $course['prerequisite'],
                'description' => $course['description'],
                'learning_outcomes' => $course['learning_outcomes'],
                'is_active' => true,
            ]);
        }
    }

    private function createTeknologiInformasiCourses($kurikulum)
    {
        $courses = [
            // Semester 1
            [
                'code' => 'TI101',
                'name' => 'Pengantar Teknologi Informasi',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Pengenalan dasar teknologi informasi, komputer, dan aplikasinya dalam berbagai bidang.',
                'learning_outcomes' => 'Mahasiswa memahami konsep dasar teknologi informasi dan dapat mengoperasikan komputer'
            ],
            [
                'code' => 'TI102',
                'name' => 'Algoritma dan Pemrograman',
                'credits' => 4,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Konsep algoritma dan pemrograman dengan fokus pada implementasi praktis dan pemecahan masalah.',
                'learning_outcomes' => 'Mahasiswa mampu membuat program sederhana untuk menyelesaikan masalah praktis'
            ],
            [
                'code' => 'TI103',
                'name' => 'Matematika Komputer',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Konsep matematika yang digunakan dalam komputasi, termasuk logika, aljabar boolean, dan sistem bilangan.',
                'learning_outcomes' => 'Mahasiswa memahami konsep matematika yang mendasari komputasi'
            ],
            [
                'code' => 'TI104',
                'name' => 'Sistem Operasi',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Pengenalan sistem operasi, instalasi, konfigurasi, dan administrasi sistem operasi.',
                'learning_outcomes' => 'Mahasiswa mampu menginstal dan mengkonfigurasi sistem operasi'
            ],

            // Semester 2-6 (key courses for D3)
            [
                'code' => 'TI201',
                'name' => 'Pemrograman Web',
                'credits' => 4,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['TI102'],
                'description' => 'Pengembangan aplikasi web menggunakan HTML, CSS, JavaScript, PHP, dan database.',
                'learning_outcomes' => 'Mahasiswa mampu membuat aplikasi web yang dinamis dan interaktif'
            ],
            [
                'code' => 'TI301',
                'name' => 'Jaringan Komputer',
                'credits' => 3,
                'semester' => 3,
                'category' => 'wajib',
                'prerequisite' => ['TI104'],
                'description' => 'Instalasi, konfigurasi, dan maintenance jaringan komputer untuk skala kecil dan menengah.',
                'learning_outcomes' => 'Mahasiswa mampu merancang dan mengimplementasikan jaringan komputer'
            ],
            [
                'code' => 'TI601',
                'name' => 'Proyek Akhir',
                'credits' => 4,
                'semester' => 6,
                'category' => 'wajib',
                'prerequisite' => ['TI201', 'TI301'],
                'description' => 'Proyek akhir berupa pengembangan aplikasi atau sistem yang menerapkan ilmu yang telah dipelajari.',
                'learning_outcomes' => 'Mahasiswa mampu mengembangkan sistem teknologi informasi secara mandiri'
            ]
        ];

        foreach ($courses as $course) {
            MataKuliah::create([
                'kurikulum_id' => $kurikulum->id,
                'code' => $course['code'],
                'name' => $course['name'],
                'credits' => $course['credits'],
                'semester' => $course['semester'],
                'category' => $course['category'],
                'prerequisite' => $course['prerequisite'],
                'description' => $course['description'],
                'learning_outcomes' => $course['learning_outcomes'],
                'is_active' => true,
            ]);
        }
    }

    private function createMagisterTeknikInformatikaCourses($kurikulum)
    {
        $courses = [
            // Semester 1
            [
                'code' => 'MTI601',
                'name' => 'Metodologi Penelitian',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Metodologi penelitian dalam bidang teknik informatika, teknik penulisan ilmiah, dan etika penelitian.',
                'learning_outcomes' => 'Mahasiswa mampu merancang dan melakukan penelitian yang valid dan reliabel'
            ],
            [
                'code' => 'MTI602',
                'name' => 'Advanced Algorithm Analysis',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Analisis algoritma lanjut, kompleksitas komputasi, dan optimisasi algoritma.',
                'learning_outcomes' => 'Mahasiswa mampu menganalisis dan mengoptimisasi algoritma kompleks'
            ],
            [
                'code' => 'MTI603',
                'name' => 'Machine Learning',
                'credits' => 3,
                'semester' => 1,
                'category' => 'wajib',
                'prerequisite' => null,
                'description' => 'Konsep lanjut machine learning, supervised dan unsupervised learning, dan implementasinya.',
                'learning_outcomes' => 'Mahasiswa mampu mengimplementasikan algoritma machine learning untuk penelitian'
            ],

            // Semester 2-4
            [
                'code' => 'MTI701',
                'name' => 'Deep Learning',
                'credits' => 3,
                'semester' => 2,
                'category' => 'wajib',
                'prerequisite' => ['MTI603'],
                'description' => 'Konsep deep learning, neural networks, convolutional networks, dan aplikasinya.',
                'learning_outcomes' => 'Mahasiswa mampu mengimplementasikan deep learning untuk penelitian lanjut'
            ],
            [
                'code' => 'MTI801',
                'name' => 'Tesis',
                'credits' => 6,
                'semester' => 4,
                'category' => 'wajib',
                'prerequisite' => ['MTI601'],
                'description' => 'Penelitian mandiri mahasiswa yang menghasilkan karya ilmiah original di bidang teknik informatika.',
                'learning_outcomes' => 'Mahasiswa menghasilkan penelitian original yang berkontribusi pada ilmu pengetahuan di bidang teknik informatika'
            ]
        ];

        foreach ($courses as $course) {
            MataKuliah::create([
                'kurikulum_id' => $kurikulum->id,
                'code' => $course['code'],
                'name' => $course['name'],
                'credits' => $course['credits'],
                'semester' => $course['semester'],
                'category' => $course['category'],
                'prerequisite' => $course['prerequisite'],
                'description' => $course['description'],
                'learning_outcomes' => $course['learning_outcomes'],
                'is_active' => true,
            ]);
        }
    }
}

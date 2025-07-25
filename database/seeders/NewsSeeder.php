<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Team;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = NewsCategory::all();
        $authors = Team::whereHas('position', function ($query) {
            $query->whereIn('name', ['Dekan', 'Ketua Program Studi', 'Lektor', 'Profesor']);
        })->get();

        $newsData = [
            [
                'title' => 'Fakultas TI Raih Akreditasi A untuk Program Studi Teknik Informatika',
                'excerpt' => 'Program Studi Teknik Informatika berhasil mempertahankan akreditasi A dari BAN-PT untuk periode 2024-2029.',
                'content' => '<p>Fakultas Teknologi Informasi dengan bangga mengumumkan bahwa Program Studi Teknik Informatika telah berhasil mempertahankan akreditasi A dari Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT) untuk periode 2024-2029.</p>

<p>Pencapaian ini merupakan hasil dari komitmen berkelanjutan fakultas dalam meningkatkan kualitas pendidikan, penelitian, dan pengabdian masyarakat. Proses akreditasi melibatkan evaluasi menyeluruh terhadap berbagai aspek, termasuk kurikulum, fasilitas, tenaga pengajar, dan lulusan.</p>

<p>"Akreditasi A ini membuktikan bahwa program studi kami telah memenuhi standar nasional pendidikan tinggi dengan sangat baik," ujar Dekan Fakultas TI, Prof. Dr. Ir. Bambang Supriyanto, M.Sc.</p>',
                'category' => 'akademik',
                'is_featured' => true,
                'tags' => ['akreditasi', 'BAN-PT', 'teknik informatika'],
            ],
            [
                'title' => 'Mahasiswa FTI Juara 1 Kompetisi Programming Nasional 2024',
                'excerpt' => 'Tim mahasiswa Fakultas TI berhasil meraih juara 1 dalam kompetisi programming tingkat nasional.',
                'content' => '<p>Tim mahasiswa Fakultas Teknologi Informasi yang terdiri dari Ahmad Rizki (TIF 2021), Sarah Putri (TIF 2021), dan David Chen (TIF 2020) berhasil meraih juara 1 dalam Kompetisi Programming Nasional 2024 yang diselenggarakan di Jakarta.</p>

<p>Kompetisi yang diikuti oleh 200 tim dari seluruh Indonesia ini menguji kemampuan algorithmic thinking dan problem solving para peserta. Tim FTI berhasil mengungguli peserta lain dengan menyelesaikan 8 dari 10 soal dalam waktu 5 jam.</p>

<p>Prestasi ini semakin memperkuat reputasi Fakultas TI sebagai salah satu fakultas teknologi informasi terbaik di Indonesia.</p>',
                'category' => 'prestasi',
                'is_featured' => true,
                'tags' => ['mahasiswa', 'programming', 'kompetisi'],
            ],
            [
                'title' => 'Kerjasama dengan Google untuk Program Sertifikasi Cloud Computing',
                'excerpt' => 'Fakultas TI menjalin kerjasama strategis dengan Google untuk program sertifikasi cloud computing bagi mahasiswa.',
                'content' => '<p>Fakultas Teknologi Informasi telah menandatangani memorandum of understanding (MoU) dengan Google Indonesia untuk program sertifikasi cloud computing. Kerjasama ini bertujuan mempersiapkan mahasiswa menghadapi era digital yang semakin berkembang.</p>

<p>Program ini akan memberikan akses kepada mahasiswa untuk mendapatkan sertifikasi Google Cloud Platform (GCP) yang diakui secara internasional. Selain itu, mahasiswa juga akan mendapat pelatihan langsung dari certified trainers Google.</p>

<p>"Kerjasama ini sejalan dengan visi kami untuk menghasilkan lulusan yang siap kerja dan memiliki kompetensi yang dibutuhkan industri," kata Wakil Dekan I, Dr. Siti Nurhaliza, M.Kom.</p>',
                'category' => 'kerjasama',
                'is_featured' => false,
                'tags' => ['google', 'cloud computing', 'sertifikasi'],
            ],
            [
                'title' => 'Penelitian AI untuk Smart City Mendapat Hibah Kemendikbud',
                'excerpt' => 'Tim peneliti Fakultas TI meraih hibah penelitian untuk pengembangan AI dalam konsep smart city.',
                'content' => '<p>Tim peneliti dari Fakultas Teknologi Informasi yang dipimpin oleh Prof. Dr. Ahmad Dahlan, M.T. berhasil meraih hibah penelitian fundamental dari Kementerian Pendidikan dan Kebudayaan untuk proyek "Pengembangan Artificial Intelligence untuk Smart City Management".</p>

<p>Penelitian ini akan mengembangkan sistem AI yang dapat mengoptimalkan pengelolaan kota pintar, mulai dari traffic management, waste management, hingga energy efficiency. Dana hibah sebesar Rp 500 juta akan digunakan untuk penelitian selama 2 tahun.</p>

<p>Tim peneliti terdiri dari 5 dosen senior dan melibatkan 10 mahasiswa S1 dan S2 sebagai research assistant.</p>',
                'category' => 'penelitian',
                'is_featured' => false,
                'tags' => ['AI', 'smart city', 'hibah penelitian'],
            ],
            [
                'title' => 'Workshop "Introduction to Machine Learning" untuk Mahasiswa Baru',
                'excerpt' => 'Fakultas TI mengadakan workshop machine learning sebagai program orientasi mahasiswa baru.',
                'content' => '<p>Dalam rangka menyambut mahasiswa baru tahun akademik 2024/2025, Fakultas Teknologi Informasi mengadakan workshop "Introduction to Machine Learning" yang diikuti oleh 150 mahasiswa baru.</p>

<p>Workshop yang berlangsung selama 3 hari ini memberikan pengenalan dasar tentang konsep machine learning, tools yang digunakan, dan hands-on practice menggunakan Python. Para peserta juga dikenalkan dengan berbagai aplikasi ML dalam kehidupan sehari-hari.</p>

<p>Acara ini dibuka langsung oleh Dekan dan menghadirkan praktisi dari industri teknologi sebagai pembicara tamu.</p>',
                'category' => 'kemahasiswaan',
                'is_featured' => false,
                'tags' => ['workshop', 'machine learning', 'mahasiswa baru'],
            ],
        ];

        foreach ($newsData as $index => $data) {
            $category = $categories->where('slug', $data['category'])->first();
            $author = $authors->random();

            News::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'featured_image' => 'https://picsum.photos/800/600?random=' . ($index + 1),
                'category_id' => $category->id,
                'author_id' => $author->id,
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
                'views_count' => rand(50, 500),
                'is_featured' => $data['is_featured'],
                'tags' => $data['tags'],
                'meta_title' => $data['title'],
                'meta_description' => $data['excerpt'],
            ]);
        }

        // Generate additional news
        for ($i = 0; $i < 20; $i++) {
            $category = $categories->random();
            $author = $authors->random();

            News::create([
                'title' => 'Berita ' . ($i + 6) . ': ' . fake()->sentence(6),
                'slug' => Str::slug('Berita ' . ($i + 6) . ' ' . fake()->words(3, true)),
                'excerpt' => fake()->paragraph(2),
                'content' => '<p>' . fake()->paragraph(5) . '</p><p>' . fake()->paragraph(4) . '</p><p>' . fake()->paragraph(3) . '</p>',
                'featured_image' => 'https://picsum.photos/800/600?random=' . ($i + 10),
                'category_id' => $category->id,
                'author_id' => $author->id,
                'status' => rand(0, 10) > 1 ? 'published' : 'draft',
                'published_at' => now()->subDays(rand(1, 90)),
                'views_count' => rand(10, 300),
                'is_featured' => rand(0, 10) > 8,
                'tags' => fake()->words(3),
                'meta_title' => fake()->sentence(8),
                'meta_description' => fake()->paragraph(1),
            ]);
        }
    }
}

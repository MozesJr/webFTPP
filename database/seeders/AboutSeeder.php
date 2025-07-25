<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        About::create([
            'title' => 'Tentang Fakultas Teknologi Informasi',
            'subtitle' => 'Pionir pendidikan teknologi informasi di Indonesia',
            'description' => '<p>Fakultas Teknologi Informasi telah berdiri sejak tahun 1995 dan telah menjadi salah satu fakultas terdepan dalam bidang teknologi informasi di Indonesia. Kami berkomitmen untuk menghasilkan lulusan yang berkualitas dan siap menghadapi tantangan era digital.</p>

<p>Dengan dukungan fasilitas modern, laboratorium terlengkap, dan tenaga pengajar yang berpengalaman, kami menyediakan pendidikan berkualitas tinggi yang sesuai dengan kebutuhan industri.</p>

<p>Fakultas kami telah meluluskan lebih dari 10.000 alumni yang tersebar di berbagai perusahaan teknologi terkemuka, baik di dalam maupun luar negeri.</p>',
            'vision' => 'Menjadi fakultas teknologi informasi terdepan di Asia Tenggara yang menghasilkan lulusan berkualitas tinggi dan berkontribusi pada pengembangan teknologi informasi.',
            'mission' => 'Menyelenggarakan pendidikan, penelitian, dan pengabdian masyarakat di bidang teknologi informasi yang inovatif, relevan, dan berkelanjutan untuk memajukan peradaban bangsa.',
            'image_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=800&h=600&fit=crop',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'video_title' => 'Profil Fakultas Teknologi Informasi',
            'video_description' => 'Tonton video profil lengkap tentang fasilitas, program studi, dan kehidupan kampus di Fakultas Teknologi Informasi',
            'is_active' => true,
        ]);
    }
}

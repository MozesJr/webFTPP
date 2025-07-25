<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\ProgramStudi;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $programStudis = ProgramStudi::all();

        $events = [
            // Upcoming Events
            [
                'title' => 'Tech Conference 2024: Future of AI in Indonesia',
                'description' => '<p>Konferensi teknologi tahunan terbesar di Indonesia yang membahas perkembangan terbaru dalam bidang Artificial Intelligence dan Machine Learning. Acara ini akan menghadirkan keynote speakers dari Google, Microsoft, dan startup teknologi terkemuka.</p>

<p><strong>Agenda Acara:</strong></p>
<ul>
<li>09:00 - 10:00: Registration & Welcome Coffee</li>
<li>10:00 - 11:30: Keynote: "AI Revolution in Southeast Asia"</li>
<li>11:45 - 12:30: Panel Discussion: "Ethics in AI Development"</li>
<li>13:30 - 15:00: Workshop: "Hands-on Machine Learning"</li>
<li>15:15 - 16:30: Startup Pitch Competition</li>
<li>16:30 - 17:00: Networking Session</li>
</ul>

<p>Acara ini terbuka untuk mahasiswa, dosen, profesional IT, dan umum.</p>',
                'event_date' => Carbon::now()->addDays(45)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(45)->setTime(17, 0),
                'location' => 'Auditorium Utama FTI, Lantai 3',
                'image_url' => 'https://picsum.photos/800/600?random=80',
                'prodi' => null,
                'status' => 'upcoming',
                'organizer' => 'Fakultas Teknologi Informasi',
                'requirements' => 'Registrasi wajib melalui website. Mahasiswa aktif mendapat diskon 50%. Bawa laptop untuk workshop.',
                'registration_url' => 'https://event.fti.ac.id/tech-conference-2024',
                'is_featured' => true,
            ],
            [
                'title' => 'Workshop Web Development dengan React & Next.js',
                'description' => '<p>Workshop intensif selama 2 hari untuk mempelajari pengembangan web modern menggunakan React.js dan Next.js. Workshop ini dirancang untuk mahasiswa yang sudah memiliki dasar HTML, CSS, dan JavaScript.</p>

<p><strong>Materi yang akan dipelajari:</strong></p>
<ul>
<li>React Fundamentals: Components, State, Props</li>
<li>React Hooks: useState, useEffect, useContext</li>
<li>Next.js: Routing, API Routes, SSR/SSG</li>
<li>Styling dengan Tailwind CSS</li>
<li>Deployment ke Vercel</li>
</ul>

<p>Setiap peserta akan membuat project portfolio website dan e-commerce sederhana.</p>',
                'event_date' => Carbon::now()->addDays(25)->setTime(8, 0),
                'end_date' => Carbon::now()->addDays(26)->setTime(16, 0),
                'location' => 'Lab Programming 1 & 2, Gedung FTI',
                'image_url' => 'https://picsum.photos/800/600?random=81',
                'prodi' => 'TIF',
                'status' => 'upcoming',
                'organizer' => 'Program Studi Teknik Informatika & React Indonesia Community',
                'requirements' => 'Mahasiswa TIF semester 3+, menguasai HTML/CSS/JavaScript dasar, membawa laptop dengan specs minimal RAM 8GB',
                'registration_url' => 'https://event.fti.ac.id/react-workshop-2024',
                'is_featured' => true,
            ],
            [
                'title' => 'Job Fair IT 2024: Career Opportunities in Digital Era',
                'description' => '<p>Job fair khusus untuk mahasiswa dan alumni bidang teknologi informasi. Acara ini menghadirkan 50+ perusahaan teknologi terkemuka yang membuka lowongan untuk fresh graduate dan experienced professionals.</p>

<p><strong>Perusahaan yang berpartisipasi:</strong></p>
<ul>
<li>Unicorn Companies: Gojek, Tokopedia, Bukalapak, Traveloka</li>
<li>Tech Giants: Google Indonesia, Microsoft Indonesia, Amazon</li>
<li>Banks: BCA, Mandiri, BNI Digital</li>
<li>Startups: Xendit, Midtrans, Halodoc, Ruangguru</li>
<li>Consulting: Accenture, Deloitte, EY Digital</li>
</ul>

<p>Selain job fair, akan ada talk show "Career Path in Tech Industry" dan workshop "Resume & Interview Tips".</p>',
                'event_date' => Carbon::now()->addDays(30)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(30)->setTime(16, 0),
                'location' => 'Exhibition Hall FTI & Virtual Platform',
                'image_url' => 'https://picsum.photos/800/600?random=82',
                'prodi' => null,
                'status' => 'upcoming',
                'organizer' => 'Career Development Center FTI',
                'requirements' => 'Mahasiswa semester 6+, alumni, atau professional. Bawa CV dalam bahasa Indonesia dan Inggris. Dress code: business casual.',
                'registration_url' => 'https://jobfair.fti.ac.id/2024',
                'is_featured' => true,
            ],
            [
                'title' => 'Seminar Nasional: "Cybersecurity in the Age of IoT"',
                'description' => '<p>Seminar nasional yang membahas tantangan keamanan siber di era Internet of Things (IoT). Menghadirkan praktisi keamanan siber dari dalam dan luar negeri.</p>

<p><strong>Pembicara:</strong></p>
<ul>
<li>Dr. Ahmad Zaki (Cybersecurity Expert, BSSN)</li>
<li>Sarah Chen (Security Architect, Singapore GovTech)</li>
<li>Prof. Budi Rahardjo (ITB)</li>
<li>Remy Phan (Penetration Tester, DEFCON Speaker)</li>
</ul>

<p>Seminar ini diakui oleh BNSP sebagai kegiatan CPD untuk sertifikasi cybersecurity.</p>',
                'event_date' => Carbon::now()->addDays(20)->setTime(13, 0),
                'end_date' => Carbon::now()->addDays(20)->setTime(17, 0),
                'location' => 'Auditorium FTI + Live Streaming YouTube',
                'image_url' => 'https://picsum.photos/800/600?random=83',
                'prodi' => 'TIF',
                'status' => 'upcoming',
                'organizer' => 'Program Studi Teknik Informatika & ID-SIRTII',
                'requirements' => 'Mahasiswa, dosen, profesional IT. Sertifikat 4 SKP untuk yang hadir penuh.',
                'registration_url' => 'https://seminar.fti.ac.id/cybersecurity-iot',
                'is_featured' => false,
            ],
            [
                'title' => 'Hackathon FTI 2024: Smart City Solutions',
                'description' => '<p>Kompetisi hackathon 48 jam untuk mengembangkan solusi smart city. Peserta akan berkompetisi untuk menciptakan aplikasi yang dapat menyelesaikan masalah urban seperti traffic management, waste management, atau energy efficiency.</p>

<p><strong>Hadiah:</strong></p>
<ul>
<li>Juara 1: Rp 15.000.000 + Inkubasi Startup</li>
<li>Juara 2: Rp 10.000.000</li>
<li>Juara 3: Rp 5.000.000</li>
<li>Best UI/UX: Rp 2.500.000</li>
<li>Most Innovative: Rp 2.500.000</li>
</ul>

<p>Semua peserta mendapat sertifikat, merchandise, dan akses ke mentor dari industry.</p>',
                'event_date' => Carbon::now()->addDays(35)->setTime(18, 0),
                'end_date' => Carbon::now()->addDays(37)->setTime(16, 0),
                'location' => 'Innovation Lab FTI (24/7 Access)',
                'image_url' => 'https://picsum.photos/800/600?random=84',
                'prodi' => null,
                'status' => 'upcoming',
                'organizer' => 'Himpunan Mahasiswa FTI & Google Developer Student Club',
                'requirements' => 'Tim 3-5 orang, minimal 1 mahasiswa FTI per tim. Bawa laptop, charger, sleeping bag optional 😄',
                'registration_url' => 'https://hackathon.fti.ac.id/2024',
                'is_featured' => true,
            ],

            // Completed Events (Recent Past)
            [
                'title' => 'Guest Lecture: "Data Science Applications in Banking"',
                'description' => '<p>Kuliah tamu dengan tema penerapan data science di industri perbankan. Pembicara: Dr. Andi Susanto, Senior Data Scientist dari Bank Central Asia (BCA).</p>

<p>Topik yang dibahas meliputi credit scoring, fraud detection, customer segmentation, dan risk management menggunakan machine learning.</p>',
                'event_date' => Carbon::now()->subDays(15)->setTime(10, 0),
                'end_date' => Carbon::now()->subDays(15)->setTime(12, 0),
                'location' => 'Ruang Kelas SI-201',
                'image_url' => 'https://picsum.photos/800/600?random=85',
                'prodi' => 'SIF',
                'status' => 'completed',
                'organizer' => 'Program Studi Sistem Informasi',
                'requirements' => 'Mahasiswa SIF yang mengambil mata kuliah Data Mining atau Business Intelligence',
                'registration_url' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Workshop Mobile App Development dengan Flutter',
                'description' => '<p>Workshop pengembangan aplikasi mobile cross-platform menggunakan Flutter. Peserta belajar membuat aplikasi mobile dari basic hingga publish ke Play Store.</p>

<p>Setiap peserta berhasil membuat dan publish 1 aplikasi mobile sederhana.</p>',
                'event_date' => Carbon::now()->subDays(30)->setTime(8, 0),
                'end_date' => Carbon::now()->subDays(29)->setTime(16, 0),
                'location' => 'Lab Mobile Development',
                'image_url' => 'https://picsum.photos/800/600?random=86',
                'prodi' => 'TIF',
                'status' => 'completed',
                'organizer' => 'Program Studi Teknik Informatika & Flutter Indonesia',
                'requirements' => 'Mahasiswa TIF dengan basic programming knowledge',
                'registration_url' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Open House FTI 2024: "Discover Your Tech Future"',
                'description' => '<p>Acara open house tahunan untuk calon mahasiswa baru dan orang tua. Acara meliputi tour fasilitas, presentasi program studi, demo project mahasiswa, dan talkshow dengan alumni sukses.</p>

<p>Acara dihadiri oleh 500+ calon mahasiswa dan orang tua dari seluruh Indonesia.</p>',
                'event_date' => Carbon::now()->subDays(60)->setTime(8, 0),
                'end_date' => Carbon::now()->subDays(60)->setTime(15, 0),
                'location' => 'Seluruh Area Fakultas Teknologi Informasi',
                'image_url' => 'https://picsum.photos/800/600?random=87',
                'prodi' => null,
                'status' => 'completed',
                'organizer' => 'Panitia Penerimaan Mahasiswa Baru FTI',
                'requirements' => 'Siswa SMA/SMK kelas 11-12 dan orang tua',
                'registration_url' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Kompetisi UI/UX Design Championship 2024',
                'description' => '<p>Kompetisi desain UI/UX tingkat nasional untuk mahasiswa. Tema tahun ini: "Designing Inclusive Digital Experiences". Peserta berkompetisi merancang aplikasi yang accessibility-friendly.</p>

<p>Kompetisi diikuti 150 tim dari 50 universitas se-Indonesia.</p>',
                'event_date' => Carbon::now()->subDays(45)->setTime(8, 0),
                'end_date' => Carbon::now()->subDays(43)->setTime(18, 0),
                'location' => 'Design Lab FTI & Online Platform',
                'image_url' => 'https://picsum.photos/800/600?random=88',
                'prodi' => 'TIF',
                'status' => 'completed',
                'organizer' => 'Himpunan Mahasiswa Teknik Informatika & UXID',
                'requirements' => 'Mahasiswa aktif S1/D3, tim 2-3 orang',
                'registration_url' => null,
                'is_featured' => false,
            ],
            [
                'title' => 'Webinar Series: "Women in Tech Leadership"',
                'description' => '<p>Seri webinar yang menghadirkan women leaders di industri teknologi untuk berbagi inspirasi dan tips berkarir di bidang teknologi.</p>

<p>Pembicara: CEO Kata.ai, CTO Bukalapak, VP Engineering Gojek, dan lainnya.</p>',
                'event_date' => Carbon::now()->subDays(20)->setTime(19, 0),
                'end_date' => Carbon::now()->subDays(20)->setTime(21, 0),
                'location' => 'Virtual Event (Zoom + YouTube Live)',
                'image_url' => 'https://picsum.photos/800/600?random=89',
                'prodi' => null,
                'status' => 'completed',
                'organizer' => 'Women in Tech Indonesia x FTI',
                'requirements' => 'Terbuka untuk umum, khususnya mahasiswi dan women professionals',
                'registration_url' => null,
                'is_featured' => false,
            ],

            // Upcoming Regular Events
            [
                'title' => 'Monthly Tech Talk: "Microservices Architecture"',
                'description' => '<p>Tech talk bulanan dengan topik arsitektur microservices. Pembahasan meliputi design patterns, deployment strategies, dan monitoring.</p>',
                'event_date' => Carbon::now()->addDays(10)->setTime(15, 0),
                'end_date' => Carbon::now()->addDays(10)->setTime(17, 0),
                'location' => 'Auditorium FTI',
                'image_url' => 'https://picsum.photos/800/600?random=90',
                'prodi' => 'TIF',
                'status' => 'upcoming',
                'organizer' => 'Tech Community FTI',
                'requirements' => 'Basic understanding of software architecture',
                'registration_url' => 'https://techtalk.fti.ac.id/microservices',
                'is_featured' => false,
            ],
            [
                'title' => 'Study Visit to AWS Indonesia Office',
                'description' => '<p>Kunjungan studi ke kantor AWS Indonesia untuk melihat langsung infrastruktur cloud computing dan berinteraksi dengan cloud engineers.</p>',
                'event_date' => Carbon::now()->addDays(50)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(50)->setTime(15, 0),
                'location' => 'AWS Indonesia Office, Menara BCA',
                'image_url' => 'https://picsum.photos/800/600?random=91',
                'prodi' => 'TI',
                'status' => 'upcoming',
                'organizer' => 'Program Studi Teknologi Informasi',
                'requirements' => 'Mahasiswa TI semester 4+, kuota terbatas 30 orang',
                'registration_url' => 'https://studyvisit.fti.ac.id/aws',
                'is_featured' => false,
            ]
        ];

        foreach ($events as $event) {
            $prodi = null;
            if ($event['prodi']) {
                $prodi = $programStudis->where('code', $event['prodi'])->first();
            }

            Event::create([
                'title' => $event['title'],
                'description' => $event['description'],
                'event_date' => $event['event_date'],
                'end_date' => $event['end_date'],
                'location' => $event['location'],
                'image_url' => $event['image_url'],
                'prodi_id' => $prodi?->id,
                'status' => $event['status'],
                'organizer' => $event['organizer'],
                'requirements' => $event['requirements'],
                'registration_url' => $event['registration_url'],
                'is_featured' => $event['is_featured'],
            ]);
        }
    }
}

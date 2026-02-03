<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GPMEDOMQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini membuat template pertanyaan EDOM standar
     * yang akan digunakan untuk evaluasi dosen
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        $questions = [
            // Kategori: Penguasaan Materi
            [
                'question' => 'Dosen menguasai materi yang diajarkan dengan baik',
                'help_text' => 'Nilai kemampuan dosen dalam menguasai materi perkuliahan',
                'category' => 'penguasaan_materi',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen mampu menjelaskan materi dengan jelas dan sistematis',
                'help_text' => null,
                'category' => 'penguasaan_materi',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen memberikan contoh-contoh yang relevan dengan materi',
                'help_text' => null,
                'category' => 'penguasaan_materi',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 3,
                'is_active' => true,
            ],
            
            // Kategori: Metode Pengajaran
            [
                'question' => 'Metode pengajaran yang digunakan dosen memudahkan pemahaman materi',
                'help_text' => 'Nilai efektivitas metode pengajaran dosen',
                'category' => 'metode_pengajaran',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen menggunakan media pembelajaran yang membantu pemahaman',
                'help_text' => 'Contoh: PPT, video, simulasi, dll',
                'category' => 'metode_pengajaran',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen memberikan kesempatan mahasiswa untuk berdiskusi dan bertanya',
                'help_text' => null,
                'category' => 'metode_pengajaran',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 6,
                'is_active' => true,
            ],
            
            // Kategori: Interaksi
            [
                'question' => 'Dosen bersikap ramah dan mudah dihubungi',
                'help_text' => 'Nilai keterbukaan dan aksesibilitas dosen',
                'category' => 'interaksi',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen memberikan respon yang baik terhadap pertanyaan mahasiswa',
                'help_text' => null,
                'category' => 'interaksi',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 8,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen memotivasi mahasiswa untuk aktif dalam pembelajaran',
                'help_text' => null,
                'category' => 'interaksi',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 9,
                'is_active' => true,
            ],
            
            // Kategori: Penilaian
            [
                'question' => 'Sistem penilaian yang diterapkan dosen adil dan transparan',
                'help_text' => 'Nilai kejelasan kriteria dan proses penilaian',
                'category' => 'penilaian',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 10,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen memberikan feedback yang konstruktif terhadap tugas/ujian',
                'help_text' => null,
                'category' => 'penilaian',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 11,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen mengembalikan hasil penilaian tepat waktu',
                'help_text' => null,
                'category' => 'penilaian',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 12,
                'is_active' => true,
            ],
            
            // Kategori: Kedisiplinan
            [
                'question' => 'Dosen hadir tepat waktu dalam perkuliahan',
                'help_text' => 'Nilai ketepatan waktu dosen',
                'category' => 'kedisiplinan',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 13,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen menyelesaikan materi sesuai dengan RPS yang telah ditetapkan',
                'help_text' => 'RPS = Rencana Pembelajaran Semester',
                'category' => 'kedisiplinan',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 14,
                'is_active' => true,
            ],
            [
                'question' => 'Dosen memberikan kompensasi jika tidak dapat hadir mengajar',
                'help_text' => null,
                'category' => 'kedisiplinan',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Setuju',
                'rating_max_label' => 'Sangat Setuju',
                'is_required' => true,
                'order' => 15,
                'is_active' => true,
            ],
            
            // Kategori: Umum - Open Questions
            [
                'question' => 'Hal positif apa yang Anda rasakan dari pembelajaran dengan dosen ini?',
                'help_text' => 'Berikan feedback positif yang konstruktif',
                'category' => 'umum',
                'type' => 'textarea',
                'rating_min' => null,
                'rating_max' => null,
                'rating_min_label' => null,
                'rating_max_label' => null,
                'is_required' => false,
                'order' => 16,
                'is_active' => true,
            ],
            [
                'question' => 'Apa saran Anda untuk perbaikan proses pembelajaran dengan dosen ini?',
                'help_text' => 'Berikan saran yang konstruktif untuk perbaikan',
                'category' => 'umum',
                'type' => 'textarea',
                'rating_min' => null,
                'rating_max' => null,
                'rating_min_label' => null,
                'rating_max_label' => null,
                'is_required' => false,
                'order' => 17,
                'is_active' => true,
            ],
            [
                'question' => 'Secara keseluruhan, bagaimana penilaian Anda terhadap dosen ini?',
                'help_text' => 'Berikan penilaian keseluruhan',
                'category' => 'umum',
                'type' => 'rating',
                'rating_min' => 1,
                'rating_max' => 5,
                'rating_min_label' => 'Sangat Tidak Puas',
                'rating_max_label' => 'Sangat Puas',
                'is_required' => true,
                'order' => 18,
                'is_active' => true,
            ],
        ];
        
        // Add timestamps to all questions
        foreach ($questions as &$question) {
            $question['created_at'] = $now;
            $question['updated_at'] = $now;
        }
        
        // Insert all questions
        DB::table('gpm_edom_questions')->insert($questions);
        
        $this->command->info('✅ EDOM Questions seeded successfully!');
        $this->command->info('📊 Total questions created: ' . count($questions));
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Questionnaire;
use App\Models\QuestionnaireCategory;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireScaleOption;
use App\Models\ProgramStudi;

class EDOMSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil prodi yang disasar
        $prodis = ProgramStudi::whereIn('name', ['Geologi', 'Pertambangan', 'Perminyakan'])->get();

        if ($prodis->isEmpty()) {
            $this->command->warn('Tidak ada ProgramStudi: Geologi/Pertambangan/Perminyakan. Seeder dilewati.');
            return;
        }

        DB::transaction(function () use ($prodis) {
            foreach ($prodis as $prodi) {
                $this->createQuestionnaireForProdi($prodi);
            }
        });
    }

    private function createQuestionnaireForProdi($prodi): void
    {
        // Hindari duplikasi bila seeder dijalankan berkali-kali
        $questionnaire = Questionnaire::firstOrCreate(
            [
                'title' => "EDOM {$prodi->name} - Semester Ganjil 2024/2025",
                'prodi_id' => $prodi->id,
                'semester' => 'Ganjil',
                'academic_year' => '2024/2025',
            ],
            [
                'description' => "Evaluasi Dosen Oleh Mahasiswa untuk Program Studi {$prodi->name}",
                'is_active' => true,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(2)->toDateString(),
            ]
        );

        // Skala penilaian (buat jika belum ada untuk kuesioner ini)
        $scaleOptions = [
            ['value' => 1, 'label' => 'Tidak Memuaskan'],
            ['value' => 2, 'label' => 'Cukup Memuaskan'],
            ['value' => 3, 'label' => 'Memuaskan'],
            ['value' => 4, 'label' => 'Sangat Memuaskan'],
        ];

        foreach ($scaleOptions as $opt) {
            QuestionnaireScaleOption::firstOrCreate(
                [
                    'questionnaire_id' => $questionnaire->id,
                    'value' => $opt['value'],
                ],
                [
                    'label' => $opt['label'],
                ]
            );
        }

        // Kategori & pertanyaan (contoh: A dan E, bisa tambah B/C/D sesuai kebutuhan)
        $categories = [
            [
                'name' => 'A. Penilaian Dosen',
                'description' => 'Penilaian terhadap dosen pengampu',
                'questions' => [
                    'Dosen hadir sesuai jadwal perkuliahan',
                    'Dosen menjelaskan materi dengan jelas',
                    'Dosen memberikan umpan balik terhadap tugas',
                    'Dosen menggunakan media pembelajaran dengan efektif',
                    'Dosen mendorong partisipasi mahasiswa',
                ],
            ],
            [
                'name' => 'E. Lain-lain',
                'description' => 'Penilaian aspek lainnya',
                'questions' => [
                    'Absensi mahasiswa dicek/dipanggil',
                    'Tugas-tugas PR dibahas',
                    'Terjadi suasana akademik yang baik',
                    'Ada transformasi pengetahuan',
                    'Mahasiswa diberi kesempatan bertanya',
                ],
            ],
        ];

        $this->createCategoriesAndQuestions($questionnaire, $categories);

        // Tambah kategori saran terbuka
        $suggestionCategory = QuestionnaireCategory::firstOrCreate(
            [
                'questionnaire_id' => $questionnaire->id,
                'name' => 'F. Saran dan Masukan',
            ],
            [
                'description' => 'Saran terbuka untuk perbaikan',
                'order_index' => 6,
            ]
        );

        QuestionnaireQuestion::firstOrCreate(
            [
                'category_id' => $suggestionCategory->id,
                'question_text' => 'Saran umum untuk perbaikan program studi',
            ],
            [
                'input_type' => 'textarea',
                'options' => null, // pastikan kolom ini nullable di DB / model-cast ke array
                'is_required' => false,
                'is_for_lecturer' => false,
                'order_index' => 1,
            ]
        );
    }

    private function createCategoriesAndQuestions(Questionnaire $questionnaire, array $categories): void
    {
        foreach ($categories as $i => $cat) {
            $category = QuestionnaireCategory::firstOrCreate(
                [
                    'questionnaire_id' => $questionnaire->id,
                    'name' => $cat['name'],
                ],
                [
                    'description' => $cat['description'] ?? null,
                    'order_index' => $i + 1,
                ]
            );

            foreach ($cat['questions'] as $j => $qText) {
                QuestionnaireQuestion::firstOrCreate(
                    [
                        'category_id' => $category->id,
                        'question_text' => $qText,
                    ],
                    [
                        'input_type' => 'radio',
                        'options' => [1, 2, 3, 4], // pastikan model cast: protected $casts = ['options' => 'array'];
                        'is_required' => true,
                        'is_for_lecturer' => true,
                        'order_index' => $j + 1,
                    ]
                );
            }
        }
    }
}

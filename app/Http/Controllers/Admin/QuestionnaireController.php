<?php

// app/Http/Controllers/Admin/QuestionnaireController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\QuestionnaireCategory;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireScaleOption;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class QuestionnaireController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'prodi_id', 'is_active']);

        $questionnaires = Questionnaire::query()
            ->with(['programStudi', 'evaluations'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('academic_year', 'like', '%' . $search . '%');
            })
            ->when($filters['prodi_id'] ?? null, function ($query, $prodiId) {
                $query->where('prodi_id', $prodiId);
            })
            ->when(isset($filters['is_active']), function ($query) use ($filters) {
                $query->where('is_active', $filters['is_active']);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Add calculated fields
        $questionnaires->getCollection()->each(function ($questionnaire) {
            $questionnaire->total_questions = $questionnaire->getTotalQuestions();
            $questionnaire->submission_count = $questionnaire->getSubmissionCount();
        });

        return Inertia::render('Admin/EDOM/Questionnaire/Index', [
            'questionnaires' => $questionnaires,
            'filters' => $filters,
            'programStudis' => ProgramStudi::active()->orderBy('name')->get(['id', 'name'])
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/EDOM/Questionnaire/Create', [
            'programStudis' => ProgramStudi::active()->orderBy('name')->get(['id', 'name']),
            'currentYear' => date('Y'),
            'defaultCategories' => $this->getDefaultCategories(),
            'defaultScaleOptions' => $this->getDefaultScaleOptions()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'prodi_id' => 'required|exists:program_studis,id',
                'semester' => 'required|string|max:50',
                'academic_year' => 'required|string|max:20',
                'is_active' => 'boolean',
                'start_date' => 'nullable|date|after_or_equal:today',
                'end_date' => 'nullable|date|after:start_date',
                'categories' => 'required|array|min:1',
                'categories.*.name' => 'required|string|max:255',
                'categories.*.description' => 'nullable|string|max:500',
                'categories.*.questions' => 'required|array|min:1',
                'categories.*.questions.*.question_text' => 'required|string|max:500',
                'categories.*.questions.*.input_type' => 'required|in:radio,textarea,select',
                'categories.*.questions.*.is_required' => 'boolean',
                'categories.*.questions.*.is_for_lecturer' => 'boolean',
                'scale_options' => 'required|array|min:2',
                'scale_options.*.value' => 'required|integer|min:1',
                'scale_options.*.label' => 'required|string|max:100'
            ], [
                'title.required' => 'Judul kuesioner wajib diisi.',
                'prodi_id.required' => 'Program Studi wajib dipilih.',
                'prodi_id.exists' => 'Program Studi tidak valid.',
                'semester.required' => 'Semester wajib diisi.',
                'academic_year.required' => 'Tahun akademik wajib diisi.',
                'categories.required' => 'Kategori pertanyaan wajib diisi.',
                'categories.min' => 'Minimal harus ada 1 kategori.',
                'scale_options.required' => 'Opsi skala penilaian wajib diisi.',
                'scale_options.min' => 'Minimal harus ada 2 opsi skala.',
            ]);

            DB::beginTransaction();

            // Create questionnaire
            $questionnaire = Questionnaire::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'prodi_id' => $validated['prodi_id'],
                'semester' => $validated['semester'],
                'academic_year' => $validated['academic_year'],
                'is_active' => $validated['is_active'] ?? true,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date']
            ]);

            // Create scale options
            foreach ($validated['scale_options'] as $scaleOption) {
                QuestionnaireScaleOption::create([
                    'questionnaire_id' => $questionnaire->id,
                    'value' => $scaleOption['value'],
                    'label' => $scaleOption['label']
                ]);
            }

            // Create categories and questions
            foreach ($validated['categories'] as $categoryIndex => $categoryData) {
                $category = QuestionnaireCategory::create([
                    'questionnaire_id' => $questionnaire->id,
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'order_index' => $categoryIndex + 1
                ]);

                foreach ($categoryData['questions'] as $questionIndex => $questionData) {
                    QuestionnaireQuestion::create([
                        'category_id' => $category->id,
                        'question_text' => $questionData['question_text'],
                        'input_type' => $questionData['input_type'],
                        'options' => $questionData['input_type'] === 'radio'
                            ? array_column($validated['scale_options'], 'value')
                            : null,
                        'is_required' => $questionData['is_required'] ?? true,
                        'is_for_lecturer' => $questionData['is_for_lecturer'] ?? true,
                        'order_index' => $questionIndex + 1
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.edom.questionnaire.index')
                ->with('message', 'Kuesioner berhasil dibuat.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating questionnaire: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat kuesioner.')->withInput();
        }
    }

    public function show(Questionnaire $questionnaire): Response
    {
        $questionnaire->load([
            'programStudi',
            'categories.questions',
            'scaleOptions',
            'evaluations.lecturer1',
            'evaluations.lecturer2'
        ]);

        // Calculate statistics
        $stats = [
            'total_submissions' => $questionnaire->evaluations->count(),
            'by_semester' => $questionnaire->evaluations
                ->groupBy('semester_taken')
                ->map->count(),
            'by_lecturer_count' => $questionnaire->evaluations
                ->groupBy('lecturer_count')
                ->map->count(),
            'completion_rate' => 0, // This would need total eligible students
            'recent_submissions' => $questionnaire->evaluations()
                ->latest('submitted_at')
                ->limit(5)
                ->get(['student_nim', 'student_name', 'submitted_at'])
        ];

        return Inertia::render('Admin/EDOM/Questionnaire/Show', [
            'questionnaire' => $questionnaire,
            'stats' => $stats
        ]);
    }

    public function update(Request $request, Questionnaire $questionnaire): RedirectResponse
    {
        try {
            // Check if questionnaire has responses
            $hasResponses = $questionnaire->evaluations()->count() > 0;

            if ($hasResponses) {
                // Limited update - only basic information
                $validated = $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string|max:1000',
                    'semester' => 'required|string|max:50',
                    'academic_year' => 'required|string|max:20',
                    'is_active' => 'boolean',
                    'start_date' => 'nullable|date',
                    'end_date' => 'nullable|date|after:start_date',
                ], [
                    'title.required' => 'Judul kuesioner wajib diisi.',
                    'semester.required' => 'Semester wajib diisi.',
                    'academic_year.required' => 'Tahun akademik wajib diisi.',
                    'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
                ]);

                // Update only basic information
                $questionnaire->update([
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'semester' => $validated['semester'],
                    'academic_year' => $validated['academic_year'],
                    'is_active' => $validated['is_active'] ?? true,
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date']
                ]);

                return redirect()->route('admin.edom.questionnaire.show', $questionnaire)
                    ->with('message', 'Informasi kuesioner berhasil diperbarui.');
            } else {
                // Full update - including structure
                $validated = $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string|max:1000',
                    'prodi_id' => 'required|exists:program_studis,id',
                    'semester' => 'required|string|max:50',
                    'academic_year' => 'required|string|max:20',
                    'is_active' => 'boolean',
                    'start_date' => 'nullable|date',
                    'end_date' => 'nullable|date|after:start_date',
                    'categories' => 'required|array|min:1',
                    'categories.*.name' => 'required|string|max:255',
                    'categories.*.description' => 'nullable|string|max:500',
                    'categories.*.questions' => 'required|array|min:1',
                    'categories.*.questions.*.question_text' => 'required|string|max:500',
                    'categories.*.questions.*.input_type' => 'required|in:radio,textarea,select',
                    'categories.*.questions.*.is_required' => 'boolean',
                    'categories.*.questions.*.is_for_lecturer' => 'boolean',
                    'scale_options' => 'required|array|min:2',
                    'scale_options.*.value' => 'required|integer|min:1',
                    'scale_options.*.label' => 'required|string|max:100'
                ], [
                    'title.required' => 'Judul kuesioner wajib diisi.',
                    'prodi_id.required' => 'Program Studi wajib dipilih.',
                    'prodi_id.exists' => 'Program Studi tidak valid.',
                    'semester.required' => 'Semester wajib diisi.',
                    'academic_year.required' => 'Tahun akademik wajib diisi.',
                    'categories.required' => 'Kategori pertanyaan wajib diisi.',
                    'categories.min' => 'Minimal harus ada 1 kategori.',
                    'scale_options.required' => 'Opsi skala penilaian wajib diisi.',
                    'scale_options.min' => 'Minimal harus ada 2 opsi skala.',
                    'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
                ]);

                DB::beginTransaction();

                // Update questionnaire basic info
                $questionnaire->update([
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'prodi_id' => $validated['prodi_id'],
                    'semester' => $validated['semester'],
                    'academic_year' => $validated['academic_year'],
                    'is_active' => $validated['is_active'] ?? true,
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date']
                ]);

                // Update scale options
                // Delete existing scale options
                $questionnaire->scaleOptions()->delete();

                // Create new scale options
                foreach ($validated['scale_options'] as $scaleOption) {
                    QuestionnaireScaleOption::create([
                        'questionnaire_id' => $questionnaire->id,
                        'value' => $scaleOption['value'],
                        'label' => $scaleOption['label']
                    ]);
                }

                // Update categories and questions
                // Delete existing categories and questions (cascade will handle questions)
                $questionnaire->categories()->delete();

                // Create new categories and questions
                foreach ($validated['categories'] as $categoryIndex => $categoryData) {
                    $category = QuestionnaireCategory::create([
                        'questionnaire_id' => $questionnaire->id,
                        'name' => $categoryData['name'],
                        'description' => $categoryData['description'],
                        'order_index' => $categoryIndex + 1
                    ]);

                    foreach ($categoryData['questions'] as $questionIndex => $questionData) {
                        QuestionnaireQuestion::create([
                            'category_id' => $category->id,
                            'question_text' => $questionData['question_text'],
                            'input_type' => $questionData['input_type'],
                            'options' => $questionData['input_type'] === 'radio'
                                ? array_column($validated['scale_options'], 'value')
                                : null,
                            'is_required' => $questionData['is_required'] ?? true,
                            'is_for_lecturer' => $questionData['is_for_lecturer'] ?? true,
                            'order_index' => $questionIndex + 1
                        ]);
                    }
                }

                DB::commit();

                return redirect()->route('admin.edom.questionnaire.show', $questionnaire)
                    ->with('message', 'Kuesioner berhasil diperbarui.');
            }
        } catch (ValidationException $e) {
            if (isset($questionnaire)) {
                DB::rollBack();
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if (isset($questionnaire)) {
                DB::rollBack();
            }
            Log::error('Error updating questionnaire: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui kuesioner.')->withInput();
        }
    }

    public function edit(Questionnaire $questionnaire): Response
    {
        $questionnaire->load([
            'categories.questions',
            'scaleOptions',
            'evaluations' // Load evaluations to check if has responses
        ]);

        return Inertia::render('Admin/EDOM/Questionnaire/Edit', [
            'questionnaire' => $questionnaire,
            'programStudis' => ProgramStudi::active()->orderBy('name')->get(['id', 'name'])
        ]);
    }

    public function destroy(Questionnaire $questionnaire): RedirectResponse
    {
        try {
            // Check if questionnaire has evaluations
            if ($questionnaire->evaluations()->count() > 0) {
                return back()->with('error', 'Tidak dapat menghapus kuesioner yang sudah memiliki respons.');
            }

            $questionnaire->delete();

            return redirect()->route('admin.edom.questionnaire.index')
                ->with('message', 'Kuesioner berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting questionnaire: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus kuesioner.');
        }
    }

    public function toggleActive(Questionnaire $questionnaire): RedirectResponse
    {
        try {
            $questionnaire->update(['is_active' => !$questionnaire->is_active]);

            $status = $questionnaire->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return back()->with('message', "Kuesioner berhasil {$status}.");
        } catch (\Exception $e) {
            Log::error('Error toggling questionnaire status: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengubah status kuesioner.');
        }
    }

    public function duplicate(Questionnaire $questionnaire): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Create new questionnaire
            $newQuestionnaire = $questionnaire->replicate();
            $newQuestionnaire->title = $questionnaire->title . ' (Copy)';
            $newQuestionnaire->is_active = false;
            $newQuestionnaire->start_date = null;
            $newQuestionnaire->end_date = null;
            $newQuestionnaire->save();

            // Duplicate scale options
            foreach ($questionnaire->scaleOptions as $scaleOption) {
                $newScaleOption = $scaleOption->replicate();
                $newScaleOption->questionnaire_id = $newQuestionnaire->id;
                $newScaleOption->save();
            }

            // Duplicate categories and questions
            foreach ($questionnaire->categories as $category) {
                $newCategory = $category->replicate();
                $newCategory->questionnaire_id = $newQuestionnaire->id;
                $newCategory->save();

                foreach ($category->questions as $question) {
                    $newQuestion = $question->replicate();
                    $newQuestion->category_id = $newCategory->id;
                    $newQuestion->save();
                }
            }

            DB::commit();

            return redirect()->route('admin.edom.questionnaire.edit', $newQuestionnaire)
                ->with('message', 'Kuesioner berhasil diduplikasi. Silakan edit sesuai kebutuhan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error duplicating questionnaire: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menduplikasi kuesioner.');
        }
    }

    private function getDefaultCategories(): array
    {
        return [
            [
                'name' => 'A. Penilaian Dosen',
                'description' => 'Penilaian terhadap dosen pengampu',
                'questions' => [
                    ['question_text' => 'Kerapian', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Sikap Selama Mengajar', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Penguasaan Materi', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Penguasaan Kelas dan Audience', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Komunikasi dengan Audience', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Teknik presentasi dan gaya penyajian serta suara', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Kreativitas tayangan dan alat bantu', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true]
                ]
            ],
            [
                'name' => 'B. Materi Perkuliahan',
                'description' => 'Penilaian terhadap materi perkuliahan',
                'questions' => [
                    ['question_text' => 'Kesesuaian materi dengan RPP/SAP', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Sistematika dan kedalaman materi', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Teknik penulisan dan gaya penyajian', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Bahasa yang digunakan mudah dimengerti', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Materi relevan dan bermanfaat', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true]
                ]
            ],
            [
                'name' => 'C. Alat dan Bahan Kuliah',
                'description' => 'Penilaian terhadap alat dan bahan kuliah',
                'questions' => [
                    ['question_text' => 'Memberikan bahan kuliah atau modul', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Menunjukkan buku literature wajib', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Memberi tugas kuliah atau pekerjaan rumah', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Memberi dan membahas contoh kasus', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Menggunakan Laptop dan LCD', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true]
                ]
            ],
            [
                'name' => 'D. Waktu',
                'description' => 'Penilaian terhadap manajemen waktu',
                'questions' => [
                    ['question_text' => 'Ketepatan waktu mulai dan selesai kuliah', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Efektivitas penggunaan waktu', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Kerajinan', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true]
                ]
            ],
            [
                'name' => 'E. Lain-lain',
                'description' => 'Penilaian aspek lainnya',
                'questions' => [
                    ['question_text' => 'Absensi mahasiswa di cek/ dipanggil', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Tugas-tugas PR dibahas', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Terjadi suasana akademik yang baik', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Ada transformasi pengetahuan', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true],
                    ['question_text' => 'Mahasiswa diberi kesempatan bertanya', 'input_type' => 'radio', 'is_required' => true, 'is_for_lecturer' => true]
                ]
            ]
        ];
    }

    private function getDefaultScaleOptions(): array
    {
        return [
            ['value' => 1, 'label' => 'Tidak Memuaskan'],
            ['value' => 2, 'label' => 'Cukup Memuaskan'],
            ['value' => 3, 'label' => 'Memuaskan'],
            ['value' => 4, 'label' => 'Sangat Memuaskan']
        ];
    }
}

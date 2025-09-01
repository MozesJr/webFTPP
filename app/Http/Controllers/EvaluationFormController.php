<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Questionnaire;
use App\Models\QuestionnaireCategory;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireScaleOption;
use App\Models\ProgramStudi;
use App\Models\Team;
use App\Models\Evaluation;
use App\Models\EvaluationAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EvaluationFormController extends Controller
{
    /**
     * Display list of available questionnaires for students
     */
    public function index(): Response
    {
        $today = now()->toDateString();

        $activeQuestionnaires = Questionnaire::active()
            ->current()
            ->with(['programStudi', 'categories.questions', 'scaleOptions'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($questionnaire) {
                return [
                    'id' => $questionnaire->id,
                    'title' => $questionnaire->title,
                    'description' => $questionnaire->description,
                    'semester' => $questionnaire->semester,
                    'academic_year' => $questionnaire->academic_year,
                    'start_date' => $questionnaire->start_date,
                    'end_date' => $questionnaire->end_date,
                    'program_studi' => $questionnaire->programStudi,
                    'categories' => $questionnaire->categories,
                    'scale_options' => $questionnaire->scaleOptions,
                    'total_questions' => $questionnaire->getTotalQuestions(),
                    'is_available' => $questionnaire->isAvailable()
                ];
            });

        return Inertia::render('EvaluationForm/Index', [
            'questionnaires' => $activeQuestionnaires
        ]);
    }

    /**
     * Show the form for creating a new evaluation
     */
    public function create(Questionnaire $questionnaire): Response
    {
        // Check if questionnaire is available
        if (!$questionnaire->is_active) {
            return redirect()->route('evaluation.index')
                ->with('error', 'Kuesioner tidak aktif.');
        }

        // Check if questionnaire is within date range
        if (!$questionnaire->isAvailable()) {
            return redirect()->route('evaluation.index')
                ->with('error', 'Kuesioner tidak dapat diisi saat ini.');
        }

        // Get lecturers for this prodi
        $lecturers = Team::where('prodi_id', $questionnaire->prodi_id)
            ->active()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $questionnaire->load([
            'categories.questions',
            'scaleOptions',
            'programStudi'
        ]);

        return Inertia::render('EvaluationForm/Create', [
            'questionnaire' => $questionnaire,
            'lecturers' => $lecturers
        ]);
    }

    /**
     * Store a newly created evaluation in storage
     */
    public function store(Request $request, Questionnaire $questionnaire): RedirectResponse
    {
        try {
            // Validate student credentials first
            $credentials = $request->validate([
                'student_nim' => 'required|string',
                'student_email' => 'required|email',
            ], [
                'student_nim.required' => 'NIM wajib diisi.',
                'student_email.required' => 'Email wajib diisi.',
                'student_email.email' => 'Format email tidak valid.',
            ]);

            // Check if student exists and verify credentials
            $student = Student::where('nim', $credentials['student_nim'])
                ->where('email', $credentials['student_email'])
                ->where('is_active', true)
                ->first();

            if (!$student) {
                // Try to find via parent relationship for backward compatibility
                $parent = ParentModel::whereHas('student', function ($query) use ($credentials) {
                    $query->where('nim', $credentials['student_nim']);
                })
                    ->where('email', $credentials['student_email'])
                    ->with('student')
                    ->first();

                if (!$parent || !$parent->student) {
                    return back()->withErrors([
                        'student_nim' => 'NIM dan email tidak terdaftar atau tidak cocok.'
                    ])->withInput();
                }

                $student = $parent->student;
            }

            // Verify student belongs to the same prodi as questionnaire
            // Check both prodi_id and program_studi (string) for compatibility
            $isValidProdi = false;

            if ($student->prodi_id && $student->prodi_id == $questionnaire->prodi_id) {
                $isValidProdi = true;
            } elseif ($student->program_studi && $questionnaire->programStudi) {
                // Fallback: compare string program_studi with program studi name
                $isValidProdi = strtolower($student->program_studi) === strtolower($questionnaire->programStudi->name);
            }

            if (!$isValidProdi) {
                return back()->withErrors([
                    'student_nim' => 'Anda tidak dapat mengisi kuesioner untuk program studi ini.'
                ])->withInput();
            }

            // Check if already submitted
            $existingEvaluation = Evaluation::where('questionnaire_id', $questionnaire->id)
                ->where('student_nim', $credentials['student_nim'])
                ->first();

            if ($existingEvaluation) {
                return back()->with('error', 'Anda sudah mengisi evaluasi untuk kuesioner ini.')
                    ->withInput();
            }

            // Validate form data
            $validated = $request->validate([
                'semester_taken' => 'required|integer|min:1|max:13',
                'lecturer_count' => 'required|integer|in:1,2',
                'lecturer_1_id' => 'required|exists:teams,id',
                'lecturer_2_id' => 'nullable|required_if:lecturer_count,2|exists:teams,id|different:lecturer_1_id',
                'attendance_lecturer_1' => 'required|in:0,1-4,5-8,>9',
                'attendance_lecturer_2' => 'nullable|required_if:lecturer_count,2|in:0,1-4,5-8,>9',
                'answers' => 'required|array',
                'general_suggestion' => 'nullable|string|max:1000',
                'suggestion_lecturer_1' => 'nullable|string|max:1000',
                'suggestion_lecturer_2' => 'nullable|string|max:1000',
            ], [
                'semester_taken.required' => 'Semester wajib dipilih.',
                'lecturer_count.required' => 'Jumlah dosen wajib dipilih.',
                'lecturer_1_id.required' => 'Dosen pengampu 1 wajib dipilih.',
                'lecturer_2_id.required_if' => 'Dosen pengampu 2 wajib dipilih.',
                'lecturer_2_id.different' => 'Dosen pengampu 2 harus berbeda dengan dosen pengampu 1.',
                'attendance_lecturer_1.required' => 'Kehadiran dosen 1 wajib dipilih.',
                'attendance_lecturer_2.required_if' => 'Kehadiran dosen 2 wajib dipilih.',
                'answers.required' => 'Jawaban evaluasi wajib diisi.',
            ]);

            // Verify lecturers belong to the same prodi
            $lecturer1 = Team::find($validated['lecturer_1_id']);
            if (!$lecturer1 || $lecturer1->prodi_id != $questionnaire->prodi_id) {
                return back()->withErrors([
                    'lecturer_1_id' => 'Dosen tidak valid untuk program studi ini.'
                ])->withInput();
            }

            if ($validated['lecturer_2_id']) {
                $lecturer2 = Team::find($validated['lecturer_2_id']);
                if (!$lecturer2 || $lecturer2->prodi_id != $questionnaire->prodi_id) {
                    return back()->withErrors([
                        'lecturer_2_id' => 'Dosen tidak valid untuk program studi ini.'
                    ])->withInput();
                }
            }

            DB::beginTransaction();

            // Create evaluation
            $evaluation = Evaluation::create([
                'student_nim' => $credentials['student_nim'],
                'student_email' => $credentials['student_email'],
                'student_name' => $student->name,
                'questionnaire_id' => $questionnaire->id,
                'semester_taken' => $validated['semester_taken'],
                'lecturer_count' => $validated['lecturer_count'],
                'lecturer_1_id' => $validated['lecturer_1_id'],
                'lecturer_2_id' => $validated['lecturer_2_id'],
                'attendance_lecturer_1' => $validated['attendance_lecturer_1'],
                'attendance_lecturer_2' => $validated['attendance_lecturer_2'],
                'general_suggestion' => $validated['general_suggestion'],
                'suggestion_lecturer_1' => $validated['suggestion_lecturer_1'],
                'suggestion_lecturer_2' => $validated['suggestion_lecturer_2'],
                'submitted_at' => now()
            ]);

            // Save answers
            foreach ($validated['answers'] as $questionId => $answerData) {
                // Verify question belongs to this questionnaire
                $question = QuestionnaireQuestion::whereHas('category', function ($q) use ($questionnaire) {
                    $q->where('questionnaire_id', $questionnaire->id);
                })->find($questionId);

                if (!$question) {
                    continue; // Skip invalid questions
                }

                if (is_array($answerData)) {
                    // For lecturer-specific questions
                    foreach ($answerData as $lecturerId => $answerValue) {
                        if (!empty($answerValue)) {
                            // Verify lecturer is one of the selected lecturers
                            if (
                                $lecturerId == $validated['lecturer_1_id'] ||
                                ($validated['lecturer_2_id'] && $lecturerId == $validated['lecturer_2_id'])
                            ) {
                                EvaluationAnswer::create([
                                    'evaluation_id' => $evaluation->id,
                                    'question_id' => $questionId,
                                    'lecturer_id' => $lecturerId,
                                    'answer_value' => $answerValue
                                ]);
                            }
                        }
                    }
                } else {
                    // For general questions
                    if (!empty($answerData)) {
                        EvaluationAnswer::create([
                            'evaluation_id' => $evaluation->id,
                            'question_id' => $questionId,
                            'lecturer_id' => null,
                            'answer_value' => $answerData
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('evaluation.success')
                ->with('message', 'Evaluasi berhasil dikirim. Terima kasih atas partisipasinya!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting evaluation: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan evaluasi.')
                ->withInput();
        }
    }

    /**
     * Show success page after evaluation submission
     */
    public function success(): Response
    {
        return Inertia::render('EvaluationForm/Success');
    }

    /**
     * Check if student credentials are valid (AJAX endpoint)
     */
    public function checkStudent(Request $request)
    {
        try {
            $validated = $request->validate([
                'nim' => 'required|string',
                'email' => 'required|email'
            ]);

            // First, try direct student lookup
            $student = Student::where('nim', $validated['nim'])
                ->where('email', $validated['email'])
                ->where('is_active', true)
                ->with('programStudi')
                ->first();

            if ($student) {
                return response()->json([
                    'valid' => true,
                    'student' => [
                        'nim' => $student->nim,
                        'name' => $student->name,
                        'email' => $student->email,
                        'prodi_id' => $student->prodi_id,
                        'prodi_name' => $student->programStudi?->name ?? $student->program_studi
                    ]
                ]);
            }

            // Fallback: check via parent relationship
            $parent = ParentModel::whereHas('student', function ($query) use ($validated) {
                $query->where('nim', $validated['nim']);
            })
                ->where('email', $validated['email'])
                ->with('student.programStudi')
                ->first();

            if (!$parent || !$parent->student) {
                return response()->json([
                    'valid' => false,
                    'message' => 'NIM dan email tidak terdaftar atau tidak cocok.'
                ], 422);
            }

            // Get student's program studi
            $programStudi = $parent->student->programStudi ?? null;

            return response()->json([
                'valid' => true,
                'student' => [
                    'nim' => $parent->student->nim,
                    'name' => $parent->student->name,
                    'email' => $validated['email'],
                    'prodi_id' => $programStudi?->id,
                    'prodi_name' => $programStudi?->name ?? $parent->student->program_studi
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Data tidak valid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error checking student: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }

    /**
     * Get available questionnaires for specific program studi
     */
    public function getByProdi(Request $request)
    {
        try {
            $validated = $request->validate([
                'prodi_id' => 'required|exists:program_studis,id'
            ]);

            $questionnaires = Questionnaire::active()
                ->current()
                ->where('prodi_id', $validated['prodi_id'])
                ->with(['programStudi', 'categories.questions'])
                ->get()
                ->map(function ($questionnaire) {
                    return [
                        'id' => $questionnaire->id,
                        'title' => $questionnaire->title,
                        'description' => $questionnaire->description,
                        'total_questions' => $questionnaire->getTotalQuestions(),
                        'is_available' => $questionnaire->isAvailable()
                    ];
                });

            return response()->json([
                'success' => true,
                'questionnaires' => $questionnaires
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting questionnaires by prodi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\GPM;

use App\Http\Controllers\Controller;
use App\Models\GPM\Survey;
use App\Models\GPM\SurveyQuestion;
use App\Models\GPM\SurveyResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Survey::query()->with('creator');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by target respondent
        if ($request->filled('target')) {
            $query->forTarget($request->target);
        }

        // Filter by status
        // if ($request->filled('status')) {
        //     match ($request->status) {
        //         'active' => $query->active(),
        //         'running' => $query->currentlyRunning(),
        //         default => null,
        //     };
        // }

        // Order
        $query->latest();

        $surveys = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/GPM/Survey/Index', [
            'surveys' => $surveys,
            'filters' => $request->only(['search', 'target', 'status']),
            'targets' => [
                'mahasiswa' => 'Mahasiswa',
                'dosen' => 'Dosen',
                'alumni' => 'Alumni',
                'stakeholder' => 'Stakeholder',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/GPM/Survey/Create', [
            'targets' => [
                'mahasiswa' => 'Mahasiswa',
                'dosen' => 'Dosen',
                'alumni' => 'Alumni',
                'stakeholder' => 'Stakeholder',
            ],
            'questionTypes' => [
                'text' => 'Text Singkat',
                'textarea' => 'Text Panjang',
                'rating' => 'Rating (1-5)',
                'multiple_choice' => 'Pilihan Ganda',
                'checkbox' => 'Multiple Selection',
                'yes_no' => 'Ya/Tidak',
                'scale' => 'Skala Likert',
                'dropdown' => 'Dropdown',
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'introduction' => 'nullable|string',
            'closing_message' => 'nullable|string',
            'target_respondent' => 'required|in:mahasiswa,dosen,alumni,stakeholder',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'is_anonymous' => 'boolean',
            'allow_multiple_responses' => 'boolean',
            'show_results' => 'boolean',
            'require_login' => 'boolean',
            'target_responses' => 'nullable|integer|min:1',
            'questions' => 'nullable|array',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:text,textarea,rating,multiple_choice,checkbox,yes_no,scale,dropdown',
            'questions.*.help_text' => 'nullable|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.is_required' => 'boolean',
        ], [
            'title.required' => 'Judul survey wajib diisi.',
            'target_respondent.required' => 'Target responden wajib dipilih.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        DB::beginTransaction();
        try {
            // Auto generate slug
            $validated['slug'] = Str::slug($validated['title']);

            // Make slug unique
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Survey::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }

            // Set created_by
            $validated['created_by'] = auth()->id();

            // Extract questions
            $questions = $validated['questions'] ?? [];
            unset($validated['questions']);

            // Create survey
            $survey = Survey::create($validated);

            // Create questions
            if (!empty($questions)) {
                foreach ($questions as $index => $questionData) {
                    $questionData['survey_id'] = $survey->id;
                    $questionData['order'] = $index + 1;
                    SurveyQuestion::create($questionData);
                }

                // Update question count
                $survey->updateQuestionCount();
            }

            DB::commit();

            return redirect()
                ->route('admin.gpm.survey.index')
                ->with('success', 'Survey berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        $survey->load(['creator', 'questions']);

        // Get response statistics
        $responseCount = $survey->responses()->count();
        $uniqueRespondents = $survey->responses()
            ->distinct('respondent_identifier')
            ->count('respondent_identifier');

        return Inertia::render('Admin/GPM/Survey/Show', [
            'survey' => $survey,
            'statistics' => [
                'total_responses' => $responseCount,
                'unique_respondents' => $uniqueRespondents,
                'completion_percentage' => $survey->completion_percentage,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        $survey->load('questions');

        return Inertia::render('Admin/GPM/Survey/Edit', [
            'survey' => $survey,
            'targets' => [
                'mahasiswa' => 'Mahasiswa',
                'dosen' => 'Dosen',
                'alumni' => 'Alumni',
                'stakeholder' => 'Stakeholder',
            ],
            'questionTypes' => [
                'text' => 'Text Singkat',
                'textarea' => 'Text Panjang',
                'rating' => 'Rating (1-5)',
                'multiple_choice' => 'Pilihan Ganda',
                'checkbox' => 'Multiple Selection',
                'yes_no' => 'Ya/Tidak',
                'scale' => 'Skala Likert',
                'dropdown' => 'Dropdown',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'introduction' => 'nullable|string',
            'closing_message' => 'nullable|string',
            'target_respondent' => 'required|in:mahasiswa,dosen,alumni,stakeholder',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'is_anonymous' => 'boolean',
            'allow_multiple_responses' => 'boolean',
            'show_results' => 'boolean',
            'require_login' => 'boolean',
            'target_responses' => 'nullable|integer|min:1',
            'questions' => 'nullable|array',
            'questions.*.id' => 'nullable|exists:gpm_survey_questions,id',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:text,textarea,rating,multiple_choice,checkbox,yes_no,scale,dropdown',
            'questions.*.help_text' => 'nullable|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.is_required' => 'boolean',
        ], [
            'title.required' => 'Judul survey wajib diisi.',
            'target_respondent.required' => 'Target responden wajib dipilih.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        DB::beginTransaction();
        try {
            // Update slug if title changed
            if ($validated['title'] !== $survey->title) {
                $validated['slug'] = Str::slug($validated['title']);

                $originalSlug = $validated['slug'];
                $count = 1;
                while (Survey::where('slug', $validated['slug'])
                    ->where('id', '!=', $survey->id)
                    ->exists()
                ) {
                    $validated['slug'] = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            // Extract questions
            $questions = $validated['questions'] ?? [];
            unset($validated['questions']);

            // Update survey
            $survey->update($validated);

            // Update questions
            $existingQuestionIds = [];

            foreach ($questions as $index => $questionData) {
                $questionData['survey_id'] = $survey->id;
                $questionData['order'] = $index + 1;

                if (isset($questionData['id'])) {
                    // Update existing question
                    $question = SurveyQuestion::find($questionData['id']);
                    if ($question && $question->survey_id === $survey->id) {
                        $question->update($questionData);
                        $existingQuestionIds[] = $questionData['id'];
                    }
                } else {
                    // Create new question
                    $newQuestion = SurveyQuestion::create($questionData);
                    $existingQuestionIds[] = $newQuestion->id;
                }
            }

            // Delete removed questions
            $survey->questions()
                ->whereNotIn('id', $existingQuestionIds)
                ->delete();

            // Update question count
            $survey->updateQuestionCount();

            DB::commit();

            return redirect()
                ->route('admin.gpm.survey.index')
                ->with('success', 'Survey berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();

        return redirect()
            ->route('admin.gpm.survey.index')
            ->with('success', 'Survey berhasil dihapus.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Survey $survey)
    {
        $survey->update([
            'is_active' => !$survey->is_active,
        ]);

        $status = $survey->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Survey berhasil {$status}.");
    }

    /**
     * Get survey results/analytics.
     */
    public function results(Survey $survey)
    {
        $survey->load('questions.responses');

        // Calculate analytics per question
        $questionAnalytics = [];

        foreach ($survey->questions as $question) {
            $analytics = [
                'question' => $question,
                'total_responses' => $question->responses()->count(),
            ];

            if ($question->isRatingType()) {
                $analytics['average_rating'] = SurveyResponse::getAverageRating($question->id);
                $analytics['rating_distribution'] = SurveyResponse::getRatingDistribution($question->id);
            } elseif ($question->hasOptions()) {
                // Count responses per option
                $analytics['option_distribution'] = $question->responses()
                    ->selectRaw('answer, COUNT(*) as count')
                    ->groupBy('answer')
                    ->pluck('count', 'answer')
                    ->toArray();
            }

            $questionAnalytics[] = $analytics;
        }

        return Inertia::render('Admin/GPM/Survey/Results', [
            'survey' => $survey,
            'statistics' => [
                'total_responses' => $survey->responses()->count(),
                'completion_rate' => $survey->completion_rate,
                'average_rating' => $survey->average_rating,
                'response_timeline' => $survey->response_timeline,
            ],
            'questionStats' => $survey->question_statistics,
        ]);
    }

    /**
     * Export survey results.
     */
    public function export(Survey $survey, Request $request)
    {
        $format = $request->get('format', 'xlsx');

        // TODO: Implement export logic
        // Use Laravel Excel or similar package

        return back()->with('info', 'Export functionality coming soon.');
    }
}

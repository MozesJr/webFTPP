<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Questionnaire;
use App\Models\ProgramStudi;
use App\Models\Team;
use App\Models\EvaluationAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class EvaluationReportController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['questionnaire_id', 'prodi_id', 'semester_taken', 'date_from', 'date_to']);

        // Basic statistics
        $totalEvaluations = Evaluation::query()
            ->when($filters['questionnaire_id'] ?? null, fn($q, $id) => $q->where('questionnaire_id', $id))
            ->when($filters['prodi_id'] ?? null, fn($q, $id) => $q->whereHas('questionnaire', fn($qq) => $qq->where('prodi_id', $id)))
            ->when($filters['semester_taken'] ?? null, fn($q, $semester) => $q->where('semester_taken', $semester))
            ->when($filters['date_from'] ?? null, fn($q, $date) => $q->whereDate('submitted_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn($q, $date) => $q->whereDate('submitted_at', '<=', $date))
            ->count();

        // Response rate by program studi
        $responseRates = ProgramStudi::withCount(['questionnaires as total_questionnaires'])
            ->withCount(['questionnaires as completed_evaluations' => function ($query) use ($filters) {
                $query->whereHas('evaluations', function ($q) use ($filters) {
                    $q->when($filters['questionnaire_id'] ?? null, fn($qq, $id) => $qq->where('questionnaire_id', $id))
                        ->when($filters['semester_taken'] ?? null, fn($qq, $semester) => $qq->where('semester_taken', $semester))
                        ->when($filters['date_from'] ?? null, fn($qq, $date) => $qq->whereDate('submitted_at', '>=', $date))
                        ->when($filters['date_to'] ?? null, fn($qq, $date) => $qq->whereDate('submitted_at', '<=', $date));
                });
            }])
            ->get()
            ->map(function ($prodi) {
                return [
                    'name' => $prodi->name,
                    'total_questionnaires' => $prodi->total_questionnaires,
                    'completed_evaluations' => $prodi->completed_evaluations,
                    'response_rate' => $prodi->total_questionnaires > 0
                        ? round(($prodi->completed_evaluations / $prodi->total_questionnaires) * 100, 2)
                        : 0
                ];
            });

        // Top rated lecturers
        $topLecturers = $this->getTopRatedLecturers($filters, 10);

        // Evaluation trends (last 12 months)
        $evaluationTrends = $this->getEvaluationTrends($filters);

        // Category analysis
        $categoryAnalysis = $this->getCategoryAnalysis($filters);

        return Inertia::render('Admin/EDOM/Reports/Index', [
            'filters' => $filters,
            'statistics' => [
                'total_evaluations' => $totalEvaluations,
                'response_rates' => $responseRates,
                'top_lecturers' => $topLecturers,
                'evaluation_trends' => $evaluationTrends,
                'category_analysis' => $categoryAnalysis,
            ],
            'questionnaires' => Questionnaire::with('programStudi')->orderBy('created_at', 'desc')->get(['id', 'title', 'prodi_id']),
            'programStudis' => ProgramStudi::active()->orderBy('name')->get(['id', 'name'])
        ]);
    }

    public function lecturerReport(Request $request): Response
    {
        $filters = $request->only(['lecturer_id', 'questionnaire_id', 'prodi_id', 'semester_taken', 'date_from', 'date_to']);

        // Get lecturers with evaluation data
        $lecturersQuery = Team::query()
            ->active()
            ->where(function ($q) {
                $q->whereHas('evaluationsAsLecturer1')
                    ->orWhereHas('evaluationsAsLecturer2');
            });

        // Apply filters
        if ($filters['prodi_id'] ?? null) {
            $lecturersQuery->where('prodi_id', $filters['prodi_id']);
        }

        $lecturers = $lecturersQuery->with(['programStudi'])
            ->get()
            ->map(function ($lecturer) use ($filters) {
                // Get evaluations for this lecturer
                $evaluations = Evaluation::query()
                    ->where(function ($q) use ($lecturer) {
                        $q->where('lecturer_1_id', $lecturer->id)
                            ->orWhere('lecturer_2_id', $lecturer->id);
                    })
                    ->when($filters['questionnaire_id'] ?? null, fn($q, $id) => $q->where('questionnaire_id', $id))
                    ->when($filters['semester_taken'] ?? null, fn($q, $semester) => $q->where('semester_taken', $semester))
                    ->when($filters['date_from'] ?? null, fn($q, $date) => $q->whereDate('submitted_at', '>=', $date))
                    ->when($filters['date_to'] ?? null, fn($q, $date) => $q->whereDate('submitted_at', '<=', $date))
                    ->get();

                // Calculate average scores
                $totalScore = 0;
                $totalAnswers = 0;

                foreach ($evaluations as $evaluation) {
                    $score1 = $evaluation->getAverageScoreForLecturer($lecturer->id);
                    if ($score1 > 0) {
                        $totalScore += $score1;
                        $totalAnswers++;
                    }
                }

                $averageScore = $totalAnswers > 0 ? round($totalScore / $totalAnswers, 2) : 0;

                return [
                    'id' => $lecturer->id,
                    'name' => $lecturer->name,
                    'email' => $lecturer->email,
                    'prodi_name' => $lecturer->programStudi->name ?? 'N/A',
                    'total_evaluations' => $evaluations->count(),
                    'average_score' => $averageScore,
                    'latest_evaluation' => $evaluations->max('submitted_at'),
                ];
            })
            ->sortByDesc('average_score')
            ->values();

        // Get detailed data for selected lecturer
        $selectedLecturerData = null;
        if ($filters['lecturer_id'] ?? null) {
            $selectedLecturerData = $this->getDetailedLecturerAnalysis($filters['lecturer_id'], $filters);
        }

        return Inertia::render('Admin/EDOM/Reports/Lecturer', [
            'filters' => $filters,
            'lecturers' => $lecturers,
            'selectedLecturerData' => $selectedLecturerData,
            'questionnaires' => Questionnaire::with('programStudi')->orderBy('created_at', 'desc')->get(['id', 'title', 'prodi_id']),
            'programStudis' => ProgramStudi::active()->orderBy('name')->get(['id', 'name']),
            'teams' => Team::active()->orderBy('name')->get(['id', 'name', 'prodi_id'])
        ]);
    }

    public function categoryReport(Request $request): Response
    {
        $filters = $request->only(['questionnaire_id', 'prodi_id', 'category_id', 'date_from', 'date_to']);

        // Get categories with analysis
        $categoryAnalysis = $this->getDetailedCategoryAnalysis($filters);

        // Get questions performance
        $questionAnalysis = $this->getQuestionAnalysis($filters);

        return Inertia::render('Admin/EDOM/Reports/Category', [
            'filters' => $filters,
            'categoryAnalysis' => $categoryAnalysis,
            'questionAnalysis' => $questionAnalysis,
            'questionnaires' => Questionnaire::with(['programStudi', 'categories'])->orderBy('created_at', 'desc')->get(),
            'programStudis' => ProgramStudi::active()->orderBy('name')->get(['id', 'name'])
        ]);
    }

    // Private helper methods
    private function getTopRatedLecturers($filters, $limit = 10)
    {
        return Team::query()
            ->active()
            ->where(function ($q) {
                $q->whereHas('evaluationsAsLecturer1')
                    ->orWhereHas('evaluationsAsLecturer2');
            })
            ->get()
            ->map(function ($lecturer) use ($filters) {
                $evaluations = Evaluation::query()
                    ->where(function ($q) use ($lecturer) {
                        $q->where('lecturer_1_id', $lecturer->id)
                            ->orWhere('lecturer_2_id', $lecturer->id);
                    })
                    ->when($filters['questionnaire_id'] ?? null, fn($q, $id) => $q->where('questionnaire_id', $id))
                    ->when($filters['prodi_id'] ?? null, fn($q, $id) => $q->whereHas('questionnaire', fn($qq) => $qq->where('prodi_id', $id)))
                    ->when($filters['semester_taken'] ?? null, fn($q, $semester) => $q->where('semester_taken', $semester))
                    ->when($filters['date_from'] ?? null, fn($q, $date) => $q->whereDate('submitted_at', '>=', $date))
                    ->when($filters['date_to'] ?? null, fn($q, $date) => $q->whereDate('submitted_at', '<=', $date))
                    ->get();

                $totalScore = 0;
                $totalAnswers = 0;

                foreach ($evaluations as $evaluation) {
                    $score = $evaluation->getAverageScoreForLecturer($lecturer->id);
                    if ($score > 0) {
                        $totalScore += $score;
                        $totalAnswers++;
                    }
                }

                return [
                    'name' => $lecturer->name,
                    'prodi_name' => $lecturer->programStudi->name ?? 'N/A',
                    'total_evaluations' => $evaluations->count(),
                    'average_score' => $totalAnswers > 0 ? round($totalScore / $totalAnswers, 2) : 0,
                ];
            })
            ->where('total_evaluations', '>', 0)
            ->sortByDesc('average_score')
            ->take($limit)
            ->values();
    }

    private function getEvaluationTrends($filters)
    {
        return Evaluation::query()
            ->selectRaw('DATE_FORMAT(submitted_at, "%Y-%m") as month, COUNT(*) as count, AVG((
            SELECT AVG(CAST(answer_value AS DECIMAL(3,2)))
            FROM evaluation_answers ea
            JOIN questionnaire_questions q ON ea.question_id = q.id
            WHERE ea.evaluation_id = evaluations.id
            AND q.input_type = "radio"
        )) as avg_score')
            ->when($filters['questionnaire_id'] ?? null, fn($q, $id) => $q->where('questionnaire_id', $id))
            ->when($filters['prodi_id'] ?? null, fn($q, $id) => $q->whereHas('questionnaire', fn($qq) => $qq->where('prodi_id', $id)))
            ->when($filters['semester_taken'] ?? null, fn($q, $semester) => $q->where('semester_taken', $semester))
            ->where('submitted_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'count' => $item->count,
                    'avg_score' => round($item->avg_score ?? 0, 2)
                ];
            });
    }


    private function getCategoryAnalysis($filters)
    {
        return DB::table('questionnaire_categories as c')
            ->join('questionnaire_questions as q', 'c.id', '=', 'q.category_id')
            ->join('evaluation_answers as ea', 'q.id', '=', 'ea.question_id')
            ->join('evaluations as e', 'ea.evaluation_id', '=', 'e.id')
            ->when($filters['questionnaire_id'] ?? null, fn($qb, $id) => $qb->where('e.questionnaire_id', $id))
            ->when($filters['prodi_id'] ?? null, function ($qb, $prodiId) {
                return $qb->join('questionnaires as qu', 'e.questionnaire_id', '=', 'qu.id')
                    ->where('qu.prodi_id', $prodiId);
            })
            ->when($filters['semester_taken'] ?? null, fn($qb, $semester) => $qb->where('e.semester_taken', $semester))
            ->when($filters['date_from'] ?? null, fn($qb, $date) => $qb->whereDate('e.submitted_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn($qb, $date) => $qb->whereDate('e.submitted_at', '<=', $date))
            ->where('q.input_type', 'radio')
            ->select('c.name', 'c.id')
            ->selectRaw('AVG(CAST(ea.answer_value AS DECIMAL(3,2))) as avg_score')
            ->selectRaw('COUNT(ea.id) as total_answers')
            ->groupBy('c.id', 'c.name')
            ->orderBy('avg_score', 'desc')
            ->get()
            ->map(fn($item) => [
                'category_name'   => $item->name,
                'avg_score'       => round($item->avg_score, 2),
                'total_answers'   => $item->total_answers,
            ]);
    }


    private function getDetailedLecturerAnalysis($lecturerId, $filters)
    {
        $lecturer = Team::find($lecturerId);
        if (!$lecturer) return null;

        $evaluations = Evaluation::query()
            ->where(function ($q) use ($lecturerId) {
                $q->where('lecturer_1_id', $lecturerId)
                    ->orWhere('lecturer_2_id', $lecturerId);
            })
            ->when($filters['questionnaire_id'] ?? null, fn($q, $id) => $q->where('questionnaire_id', $id))
            ->when($filters['semester_taken'] ?? null, fn($q, $semester) => $q->where('semester_taken', $semester))
            ->when($filters['date_from'] ?? null, fn($q, $date) => $q->whereDate('submitted_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn($q, $date) => $q->whereDate('submitted_at', '<=', $date))
            ->with(['questionnaire', 'answers.question.category'])
            ->get();

        // Performance by category
        $categoryPerformance = [];
        foreach ($evaluations as $evaluation) {
            foreach ($evaluation->answers as $answer) {
                if ($answer->lecturer_id == $lecturerId && $answer->question->input_type === 'radio') {
                    $categoryName = $answer->question->category->name;
                    if (!isset($categoryPerformance[$categoryName])) {
                        $categoryPerformance[$categoryName] = ['scores' => [], 'total' => 0, 'count' => 0];
                    }
                    $categoryPerformance[$categoryName]['scores'][] = (float) $answer->answer_value;
                    $categoryPerformance[$categoryName]['total'] += (float) $answer->answer_value;
                    $categoryPerformance[$categoryName]['count']++;
                }
            }
        }

        $categoryAnalysis = collect($categoryPerformance)->map(function ($data, $categoryName) {
            return [
                'category_name' => $categoryName,
                'average_score' => round($data['total'] / $data['count'], 2),
                'total_responses' => $data['count'],
                'min_score' => min($data['scores']),
                'max_score' => max($data['scores'])
            ];
        })->sortByDesc('average_score')->values();

        // Recent evaluations
        $recentEvaluations = $evaluations->sortByDesc('submitted_at')->take(10)->map(function ($evaluation) use ($lecturerId) {
            return [
                'student_name' => $evaluation->student_name,
                'questionnaire_title' => $evaluation->questionnaire->title,
                'average_score' => $evaluation->getAverageScoreForLecturer($lecturerId),
                'submitted_at' => $evaluation->submitted_at->format('Y-m-d H:i')
            ];
        });

        return [
            'lecturer' => $lecturer,
            'total_evaluations' => $evaluations->count(),
            'category_analysis' => $categoryAnalysis,
            'recent_evaluations' => $recentEvaluations,
            'overall_average' => $categoryAnalysis->avg('average_score')
        ];
    }

    private function getDetailedCategoryAnalysis($filters)
    {
        return DB::table('questionnaire_categories as c')
            ->join('questionnaire_questions as q', 'c.id', '=', 'q.category_id')
            ->join('evaluation_answers as ea', 'q.id', '=', 'ea.question_id')
            ->join('evaluations as e', 'ea.evaluation_id', '=', 'e.id')
            ->when($filters['questionnaire_id'] ?? null, fn($qb, $id) => $qb->where('e.questionnaire_id', $id))
            ->when($filters['prodi_id'] ?? null, function ($qb, $prodiId) {
                return $qb->join('questionnaires as qu', 'e.questionnaire_id', '=', 'qu.id')
                    ->where('qu.prodi_id', $prodiId);
            })
            ->when($filters['date_from'] ?? null, fn($qb, $date) => $qb->whereDate('e.submitted_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn($qb, $date) => $qb->whereDate('e.submitted_at', '<=', $date))
            ->where('q.input_type', 'radio')
            ->select('c.name', 'c.id', 'c.description')
            ->selectRaw('AVG(CAST(ea.answer_value AS DECIMAL(3,2))) as avg_score')
            ->selectRaw('COUNT(ea.id) as total_answers')
            ->selectRaw('MIN(CAST(ea.answer_value AS DECIMAL(3,2))) as min_score')
            ->selectRaw('MAX(CAST(ea.answer_value AS DECIMAL(3,2))) as max_score')
            ->groupBy('c.id', 'c.name', 'c.description')
            ->orderBy('avg_score', 'desc')
            ->get();
    }


    private function getQuestionAnalysis($filters)
    {
        return DB::table('questionnaire_questions as q')
            ->join('evaluation_answers as ea', 'q.id', '=', 'ea.question_id')
            ->join('evaluations as e', 'ea.evaluation_id', '=', 'e.id')
            ->join('questionnaire_categories as c', 'q.category_id', '=', 'c.id')
            ->when($filters['questionnaire_id'] ?? null, fn($qb, $id) => $qb->where('e.questionnaire_id', $id))
            ->when($filters['prodi_id'] ?? null, function ($qb, $prodiId) {
                return $qb->join('questionnaires as qu', 'e.questionnaire_id', '=', 'qu.id')
                    ->where('qu.prodi_id', $prodiId);
            })
            ->when($filters['category_id'] ?? null, fn($qb, $id) => $qb->where('q.category_id', $id))
            ->when($filters['date_from'] ?? null, fn($qb, $date) => $qb->whereDate('e.submitted_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn($qb, $date) => $qb->whereDate('e.submitted_at', '<=', $date))
            ->where('q.input_type', 'radio')
            ->select(
                'q.question_text',
                'q.id',
                'c.name as category_name'
            )
            ->selectRaw('AVG(CAST(ea.answer_value AS DECIMAL(3,2))) as avg_score')
            ->selectRaw('COUNT(ea.id) as total_answers')
            ->groupBy('q.id', 'q.question_text', 'c.name')
            ->orderBy('avg_score', 'desc')
            ->get();
    }
}

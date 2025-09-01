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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EvaluationExport;

class EvaluationController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'questionnaire_id', 'prodi_id', 'semester_taken']);

        $evaluations = Evaluation::query()
            ->with(['questionnaire.programStudi', 'lecturer1', 'lecturer2'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('student_nim', 'like', '%' . $search . '%')
                    ->orWhere('student_name', 'like', '%' . $search . '%')
                    ->orWhere('student_email', 'like', '%' . $search . '%');
            })
            ->when($filters['questionnaire_id'] ?? null, function ($query, $questionnaireId) {
                $query->where('questionnaire_id', $questionnaireId);
            })
            ->when($filters['prodi_id'] ?? null, function ($query, $prodiId) {
                $query->whereHas('questionnaire', function ($q) use ($prodiId) {
                    $q->where('prodi_id', $prodiId);
                });
            })
            ->when($filters['semester_taken'] ?? null, function ($query, $semester) {
                $query->where('semester_taken', $semester);
            })
            ->latest('submitted_at')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/EDOM/Evaluation/Index', [
            'evaluations' => $evaluations,
            'filters' => $filters,
            'questionnaires' => Questionnaire::with('programStudi')->orderBy('created_at', 'desc')->get(['id', 'title', 'prodi_id']),
            'programStudis' => ProgramStudi::active()->orderBy('name')->get(['id', 'name'])
        ]);
    }

    public function show(Evaluation $evaluation): Response
    {
        $evaluation->load([
            'questionnaire.programStudi',
            'questionnaire.categories.questions',
            'lecturer1',
            'lecturer2',
            'answers.question.category'
        ]);

        // Group answers by category and lecturer
        $groupedAnswers = [];

        foreach ($evaluation->questionnaire->categories as $category) {
            $groupedAnswers[$category->name] = [];

            foreach ($category->questions as $question) {
                $questionAnswers = $evaluation->answers
                    ->where('question_id', $question->id);

                if ($question->is_for_lecturer) {
                    // Group by lecturer
                    foreach ($questionAnswers as $answer) {
                        $lecturerKey = $answer->lecturer_id == $evaluation->lecturer_1_id ? 'lecturer_1' : 'lecturer_2';
                        $groupedAnswers[$category->name][$lecturerKey][] = [
                            'question' => $question,
                            'answer' => $answer
                        ];
                    }
                } else {
                    // General question
                    $groupedAnswers[$category->name]['general'][] = [
                        'question' => $question,
                        'answer' => $questionAnswers->first()
                    ];
                }
            }
        }

        return Inertia::render('Admin/EDOM/Evaluation/Show', [
            'evaluation' => $evaluation,
            'groupedAnswers' => $groupedAnswers
        ]);
    }

    public function export(Request $request)
    {
        $filters = $request->only(['questionnaire_id', 'prodi_id', 'semester_taken']);

        return Excel::download(
            new EvaluationExport($filters),
            'evaluasi-dosen-' . date('Y-m-d') . '.xlsx'
        );
    }

    public function destroy(Evaluation $evaluation)
    {
        try {
            $evaluation->delete();

            return redirect()->route('admin.edom.evaluation.index')
                ->with('message', 'Evaluasi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus evaluasi.');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\GPM;

use App\Http\Controllers\Controller;
use App\Models\GPM\EDOMPeriod;
use App\Models\GPM\EDOMQuestion;
use App\Models\GPM\EDOMSubmission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class EDOMPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EDOMPeriod::query()->with('creator');

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('academic_year', 'like', "%{$request->search}%");
            });
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->semester($request->semester);
        }

        // Filter by academic year
        if ($request->filled('academic_year')) {
            $query->academicYear($request->academic_year);
        }

        // Filter by status
        if ($request->filled('status')) {
            match ($request->status) {
                'active' => $query->active(),
                'published' => $query->published(),
                default => null,
            };
        }

        // Order
        $query->latest();

        $periods = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/GPM/EDOMPeriod/Index', [
            'periods' => $periods,
            'filters' => $request->only(['search', 'semester', 'academic_year', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/GPM/EDOMPeriod/Create', [
            'questionCount' => EDOMQuestion::active()->count(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|in:ganjil,genap',
            'academic_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'require_all_courses' => 'boolean',
            'show_results_to_students' => 'boolean',
            'total_students' => 'nullable|integer|min:0',
            'total_lecturers' => 'nullable|integer|min:0',
            'total_courses' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'Nama periode wajib diisi.',
            'semester.required' => 'Semester wajib dipilih.',
            'academic_year.required' => 'Tahun ajaran wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        // Set created_by
        $validated['created_by'] = auth()->id();

        EDOMPeriod::create($validated);

        return redirect()
            ->route('admin.gpm.edom-period.index')
            ->with('success', 'Periode EDOM berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EDOMPeriod $edomPeriod)
    {
        $edomPeriod->load('creator');

        // Get statistics
        $statistics = [
            'total_submissions' => $edomPeriod->submissions()->count(),
            'unique_students' => $edomPeriod->submissions()->distinct('student_id')->count('student_id'),
            'unique_lecturers' => $edomPeriod->submissions()->distinct('lecturer_id')->count('lecturer_id'),
            'average_score' => $edomPeriod->submissions()->avg('average_score') ?? 0,
            'completion_percentage' => $edomPeriod->completion_percentage,
        ];

        // Get top rated lecturers
        $topLecturers = $edomPeriod->submissions()
            ->select('lecturer_id', DB::raw('AVG(average_score) as avg_score'), DB::raw('COUNT(*) as submission_count'))
            ->groupBy('lecturer_id')
            ->orderBy('avg_score', 'desc')
            ->limit(10)
            ->with('lecturer:id,name')
            ->get();

        // Get submission trend (per day)
        $submissionTrend = $edomPeriod->submissions()
            ->selectRaw('DATE(submitted_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return Inertia::render('Admin/GPM/EDOMPeriod/Show', [
            'period' => $edomPeriod,
            'statistics' => $statistics,
            'topLecturers' => $topLecturers,
            'submissionTrend' => $submissionTrend,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EDOMPeriod $edomPeriod)
    {
        return Inertia::render('Admin/GPM/EDOMPeriod/Edit', [
            'period' => $edomPeriod,
            'questionCount' => EDOMQuestion::active()->count(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EDOMPeriod $edomPeriod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|in:ganjil,genap',
            'academic_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'is_published' => 'boolean',
            'require_all_courses' => 'boolean',
            'show_results_to_students' => 'boolean',
            'total_students' => 'nullable|integer|min:0',
            'total_lecturers' => 'nullable|integer|min:0',
            'total_courses' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'Nama periode wajib diisi.',
            'semester.required' => 'Semester wajib dipilih.',
            'academic_year.required' => 'Tahun ajaran wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        $edomPeriod->update($validated);

        return redirect()
            ->route('admin.gpm.edom-period.index')
            ->with('success', 'Periode EDOM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EDOMPeriod $edomPeriod)
    {
        $edomPeriod->delete();

        return redirect()
            ->route('admin.gpm.edom-period.index')
            ->with('success', 'Periode EDOM berhasil dihapus.');
    }

    /**
     * Toggle active status.
     */

    public function toggleActive(EDOMPeriod $edomPeriod)
    {
        // Deactivate other active periods if activating this one
        if (!$edomPeriod->is_active) {
            EDOMPeriod::where('is_active', true)
                ->where('id', '!=', $edomPeriod->id)
                ->update(['is_active' => false]);
        }

        $edomPeriod->update([
            'is_active' => !$edomPeriod->is_active,
        ]);

        $status = $edomPeriod->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Periode EDOM berhasil {$status}.");
    }

    /**
     * Toggle publish status.
     */
    public function togglePublish(EDOMPeriod $edomPeriod)
    {
        $edomPeriod->update([
            'is_published' => !$edomPeriod->is_published,
        ]);

        $status = $edomPeriod->is_published ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Hasil EDOM berhasil {$status}.");
    }

    /**
     * Update statistics.
     */
    public function updateStatistics(EDOMPeriod $edomPeriod)
    {
        $edomPeriod->updateStatistics();

        return back()->with('success', 'Statistik berhasil diperbarui.');
    }

    /**
     * Get lecturer statistics for a period.
     */
    public function lecturerStatistics(EDOMPeriod $edomPeriod, Request $request)
    {
        $query = $edomPeriod->submissions()
            ->select(
                'lecturer_id',
                DB::raw('COUNT(*) as submission_count'),
                DB::raw('AVG(average_score) as average_score'),
                DB::raw('MIN(average_score) as min_score'),
                DB::raw('MAX(average_score) as max_score')
            )
            ->groupBy('lecturer_id')
            ->with('lecturer:id,name,email');

        // Search
        if ($request->filled('search')) {
            $query->whereHas('lecturer', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Order
        $sortBy = $request->get('sort_by', 'average_score');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $lecturerStats = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/GPM/EDOMPeriod/LecturerStatistics', [
            'period' => $edomPeriod,
            'lecturerStats' => $lecturerStats,
            'filters' => $request->only(['search', 'sort_by', 'sort_order']),
        ]);
    }

    /**
     * Get submission details for a specific lecturer in a period.
     */
    public function lecturerSubmissions(EDOMPeriod $edomPeriod, Request $request)
    {
        $lecturerId = $request->get('lecturer_id');

        if (!$lecturerId) {
            return back()->withErrors(['error' => 'Lecturer ID required.']);
        }

        $submissions = $edomPeriod->submissions()
            ->where('lecturer_id', $lecturerId)
            ->with(['student:id,name', 'lecturer:id,name'])
            ->latest('submitted_at')
            ->paginate(15)
            ->withQueryString();

        // Get average scores by category
        $categoryScores = $edomPeriod->submissions()
            ->where('lecturer_id', $lecturerId)
            ->get()
            ->pluck('category_scores')
            ->filter()
            ->reduce(function ($carry, $scores) {
                foreach ($scores as $category => $score) {
                    if (!isset($carry[$category])) {
                        $carry[$category] = ['total' => 0, 'count' => 0];
                    }
                    $carry[$category]['total'] += $score;
                    $carry[$category]['count']++;
                }
                return $carry;
            }, []);

        // Calculate averages
        $categoryAverages = [];
        foreach ($categoryScores as $category => $data) {
            $categoryAverages[$category] = $data['count'] > 0
                ? round($data['total'] / $data['count'], 2)
                : 0;
        }

        return Inertia::render('Admin/GPM/EDOMPeriod/LecturerSubmissions', [
            'period' => $edomPeriod,
            'submissions' => $submissions,
            'categoryAverages' => $categoryAverages,
            'lecturer' => $submissions->first()?->lecturer,
        ]);
    }

    /**
     * Export EDOM results.
     */
    public function export(EDOMPeriod $edomPeriod, Request $request)
    {
        $format = $request->get('format', 'xlsx');

        // TODO: Implement export logic
        // Use Laravel Excel or similar package

        return back()->with('info', 'Export functionality coming soon.');
    }
}

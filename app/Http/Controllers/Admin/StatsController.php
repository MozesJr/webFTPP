<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stats;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Helpers\StatsHelper;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $query = Stats::orderBy('year', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('year', 'like', "%{$search}%");
            });
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $stats = $query->paginate(10)->withQueryString();

        // Get chart data for all years
        $chartData = $this->getChartData();

        // Get summary data
        $summaryData = $this->getSummaryData();

        // Get available years for filter
        $availableYears = Stats::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return Inertia::render('Admin/Stats/Index', [
            'stats' => $stats,
            'filters' => $request->only(['search', 'year']),
            'chartData' => $chartData,
            'summaryData' => $summaryData,
            'availableYears' => $availableYears,
        ]);
    }

    public function create()
    {
        // Get next year suggestion
        $latestYear = Stats::max('year') ?? date('Y');
        $suggestedYear = $latestYear + 1;

        return Inertia::render('Admin/Stats/Create', [
            'suggestedYear' => $suggestedYear,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_students' => 'required|integer|min:0',
            'total_partnerships' => 'required|integer|min:0',
            'total_alumni' => 'required|integer|min:0',
            'total_lecturers' => 'required|integer|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'is_current' => 'boolean',
        ]);

        // If setting as current, remove current status from others
        if ($request->is_current) {
            Stats::where('is_current', true)->update(['is_current' => false]);
        }

        Stats::create($request->all());

        return redirect()->route('admin.stats.index')
            ->with('message', 'Statistik berhasil ditambahkan.');
    }

    public function show(Stats $stat)
    {
        // Get comparison with previous year
        $previousYear = Stats::where('year', '<', $stat->year)
            ->orderBy('year', 'desc')
            ->first();

        $nextYear = Stats::where('year', '>', $stat->year)
            ->orderBy('year', 'asc')
            ->first();

        // Calculate growth rates
        $growthRates = null;
        if ($previousYear) {
            $growthRates = [
                'students' => $this->calculateGrowthRate($previousYear->total_students, $stat->total_students),
                'partnerships' => $this->calculateGrowthRate($previousYear->total_partnerships, $stat->total_partnerships),
                'alumni' => $this->calculateGrowthRate($previousYear->total_alumni, $stat->total_alumni),
                'lecturers' => $this->calculateGrowthRate($previousYear->total_lecturers, $stat->total_lecturers),
            ];
        }

        return Inertia::render('Admin/Stats/Show', [
            'stat' => $stat,
            'previousYear' => $previousYear,
            'nextYear' => $nextYear,
            'growthRates' => $growthRates,
        ]);
    }

    public function edit(Stats $stat)
    {
        return Inertia::render('Admin/Stats/Edit', [
            'stat' => $stat,
        ]);
    }

    public function update(Request $request, Stats $stat)
    {
        $request->validate([
            'total_students' => 'required|integer|min:0',
            'total_partnerships' => 'required|integer|min:0',
            'total_alumni' => 'required|integer|min:0',
            'total_lecturers' => 'required|integer|min:0',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'is_current' => 'boolean',
        ]);

        // If setting as current, remove current status from others
        if ($request->is_current && !$stat->is_current) {
            Stats::where('is_current', true)->update(['is_current' => false]);
        }

        $stat->update($request->all());

        return redirect()->route('admin.stats.index')
            ->with('message', 'Statistik berhasil diperbarui.');
    }

    public function destroy(Stats $stat)
    {
        try {
            $stat->delete();

            return redirect()->route('admin.stats.index')
                ->with('message', 'Statistik berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.stats.index')
                ->with('error', 'Terjadi kesalahan saat menghapus statistik.');
        }
    }

    public function setCurrent(Stats $stat)
    {
        // Remove current status from all
        Stats::where('is_current', true)->update(['is_current' => false]);

        // Set current
        $stat->update(['is_current' => true]);

        return redirect()->route('admin.stats.index')
            ->with('message', 'Statistik tahun ' . $stat->year . ' berhasil diset sebagai data terkini.');
    }

    public function getChartApi()
    {
        return response()->json($this->getChartData());
    }

    public function getCurrentStats()
    {
        $currentStats = Stats::current()->first();

        if (!$currentStats) {
            $currentStats = Stats::orderBy('year', 'desc')->first();
        }

        return response()->json($currentStats);
    }

    private function getChartData()
    {
        $stats = Stats::orderBy('year', 'asc')->get();

        return [
            'years' => $stats->pluck('year')->toArray(),
            'students' => $stats->pluck('total_students')->toArray(),
            'partnerships' => $stats->pluck('total_partnerships')->toArray(),
            'alumni' => $stats->pluck('total_alumni')->toArray(),
            'lecturers' => $stats->pluck('total_lecturers')->toArray(),
        ];
    }

    private function getSummaryData()
    {
        $currentStats = Stats::current()->first();
        $latestStats = Stats::orderBy('year', 'desc')->first();

        // Use current if available, otherwise use latest
        $displayStats = $currentStats ?: $latestStats;

        $totalRecords = Stats::count();
        $yearRange = [
            'earliest' => Stats::min('year'),
            'latest' => Stats::max('year'),
        ];

        // Calculate average growth rates
        $avgGrowthRates = $this->calculateAverageGrowthRates();

        return [
            'current' => $displayStats,
            'totalRecords' => $totalRecords,
            'yearRange' => $yearRange,
            'avgGrowthRates' => $avgGrowthRates,
        ];
    }

    private function calculateGrowthRate($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 2);
    }

    private function calculateAverageGrowthRates()
    {
        $stats = Stats::orderBy('year', 'asc')->get();

        if ($stats->count() < 2) {
            return null;
        }

        $growthRates = [
            'students' => [],
            'partnerships' => [],
            'alumni' => [],
            'lecturers' => [],
        ];

        for ($i = 1; $i < $stats->count(); $i++) {
            $previous = $stats[$i - 1];
            $current = $stats[$i];

            $growthRates['students'][] = $this->calculateGrowthRate($previous->total_students, $current->total_students);
            $growthRates['partnerships'][] = $this->calculateGrowthRate($previous->total_partnerships, $current->total_partnerships);
            $growthRates['alumni'][] = $this->calculateGrowthRate($previous->total_alumni, $current->total_alumni);
            $growthRates['lecturers'][] = $this->calculateGrowthRate($previous->total_lecturers, $current->total_lecturers);
        }

        return [
            'students' => round(array_sum($growthRates['students']) / count($growthRates['students']), 2),
            'partnerships' => round(array_sum($growthRates['partnerships']) / count($growthRates['partnerships']), 2),
            'alumni' => round(array_sum($growthRates['alumni']) / count($growthRates['alumni']), 2),
            'lecturers' => round(array_sum($growthRates['lecturers']) / count($growthRates['lecturers']), 2),
        ];
    }
}

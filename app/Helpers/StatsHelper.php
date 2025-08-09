<?php

namespace App\Helpers;

use App\Models\Stats;
use Illuminate\Support\Facades\Cache;

class StatsHelper
{
    const CACHE_DURATION = 3600; // 1 hour

    /**
     * Get current statistics
     */
    public static function getCurrentStats()
    {
        return Cache::remember('stats_current', self::CACHE_DURATION, function () {
            $current = Stats::current()->first();
            return $current ?: Stats::orderBy('year', 'desc')->first();
        });
    }

    /**
     * Get all statistics for chart
     */
    public static function getChartData()
    {
        return Cache::remember('stats_chart_data', self::CACHE_DURATION, function () {
            $stats = Stats::orderBy('year', 'asc')->get();

            return [
                'years' => $stats->pluck('year')->toArray(),
                'students' => $stats->pluck('total_students')->toArray(),
                'partnerships' => $stats->pluck('total_partnerships')->toArray(),
                'alumni' => $stats->pluck('total_alumni')->toArray(),
                'lecturers' => $stats->pluck('total_lecturers')->toArray(),
            ];
        });
    }

    /**
     * Get statistics for specific year
     */
    public static function getStatsByYear($year)
    {
        return Cache::remember("stats_year_{$year}", self::CACHE_DURATION, function () use ($year) {
            return Stats::forYear($year)->first();
        });
    }

    /**
     * Get growth rate between two years
     */
    public static function getGrowthRate($previousValue, $currentValue)
    {
        if ($previousValue == 0) {
            return $currentValue > 0 ? 100 : 0;
        }

        return round((($currentValue - $previousValue) / $previousValue) * 100, 2);
    }

    /**
     * Get yearly summary with growth rates
     */
    public static function getYearlySummary()
    {
        return Cache::remember('stats_yearly_summary', self::CACHE_DURATION, function () {
            $stats = Stats::orderBy('year', 'asc')->get();

            if ($stats->count() < 2) {
                return null;
            }

            $summary = [];
            for ($i = 1; $i < $stats->count(); $i++) {
                $previous = $stats[$i - 1];
                $current = $stats[$i];

                $summary[] = [
                    'year' => $current->year,
                    'data' => $current,
                    'growth' => [
                        'students' => self::getGrowthRate($previous->total_students, $current->total_students),
                        'partnerships' => self::getGrowthRate($previous->total_partnerships, $current->total_partnerships),
                        'alumni' => self::getGrowthRate($previous->total_alumni, $current->total_alumni),
                        'lecturers' => self::getGrowthRate($previous->total_lecturers, $current->total_lecturers),
                    ]
                ];
            }

            return $summary;
        });
    }

    /**
     * Clear all stats cache
     */
    public static function clearCache()
    {
        Cache::forget('stats_current');
        Cache::forget('stats_chart_data');
        Cache::forget('stats_yearly_summary');

        // Clear year-specific caches
        $years = Stats::pluck('year');
        foreach ($years as $year) {
            Cache::forget("stats_year_{$year}");
        }
    }

    /**
     * Get public stats for frontend API
     */
    public static function getPublicStats()
    {
        $current = self::getCurrentStats();
        $chart = self::getChartData();

        return [
            'current' => $current,
            'chart' => $chart,
            'summary' => self::getYearlySummary(),
        ];
    }
}

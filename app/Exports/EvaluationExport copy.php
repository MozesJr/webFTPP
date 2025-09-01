<?php

namespace App\Exports;

use App\Models\Evaluation;
use App\Models\EvaluationAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EvaluationExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Evaluation::query()
            ->with([
                'questionnaire.programStudi',
                'lecturer1',
                'lecturer2',
                'answers.question.category'
            ])
            ->when($this->filters['questionnaire_id'] ?? null, function ($query, $questionnaireId) {
                $query->where('questionnaire_id', $questionnaireId);
            })
            ->when($this->filters['prodi_id'] ?? null, function ($query, $prodiId) {
                $query->whereHas('questionnaire', function ($q) use ($prodiId) {
                    $q->where('prodi_id', $prodiId);
                });
            })
            ->when($this->filters['semester_taken'] ?? null, function ($query, $semester) {
                $query->where('semester_taken', $semester);
            })
            ->orderBy('submitted_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'NIM Mahasiswa',
            'Nama Mahasiswa',
            'Email',
            'Program Studi',
            'Kuesioner',
            'Semester',
            'Tahun Akademik',
            'Semester Diambil',
            'Jumlah Dosen',
            'Dosen 1',
            'Kehadiran Dosen 1',
            'Dosen 2',
            'Kehadiran Dosen 2',
            'Rata-rata Nilai Dosen 1',
            'Rata-rata Nilai Dosen 2',
            'Saran Umum',
            'Saran Dosen 1',
            'Saran Dosen 2',
            'Tanggal Submit'
        ];
    }

    public function map($evaluation): array
    {
        // Calculate average scores for each lecturer
        $avgScore1 = $evaluation->getAverageScoreForLecturer($evaluation->lecturer_1_id);
        $avgScore2 = $evaluation->lecturer_2_id ? $evaluation->getAverageScoreForLecturer($evaluation->lecturer_2_id) : null;

        return [
            $evaluation->id,
            $evaluation->student_nim,
            $evaluation->student_name,
            $evaluation->student_email,
            $evaluation->questionnaire->programStudi->name ?? '',
            $evaluation->questionnaire->title,
            $evaluation->questionnaire->semester,
            $evaluation->questionnaire->academic_year,
            $evaluation->semester_taken,
            $evaluation->lecturer_count,
            $evaluation->lecturer1->name ?? '',
            $evaluation->attendance_lecturer_1,
            $evaluation->lecturer2->name ?? '',
            $evaluation->attendance_lecturer_2,
            $avgScore1,
            $avgScore2,
            $evaluation->general_suggestion,
            $evaluation->suggestion_lecturer_1,
            $evaluation->suggestion_lecturer_2,
            $evaluation->submitted_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Evaluation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EvaluationExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Evaluation::query()
            ->with(['questionnaire.programStudi', 'lecturer1', 'lecturer2', 'answers.question.category'])
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
            'No',
            'NIM Mahasiswa',
            'Nama Mahasiswa',
            'Email Mahasiswa',
            'Kuesioner',
            'Program Studi',
            'Semester',
            'Jumlah Dosen',
            'Dosen 1',
            'Kehadiran Dosen 1',
            'Rata-rata Skor Dosen 1',
            'Saran untuk Dosen 1',
            'Dosen 2',
            'Kehadiran Dosen 2',
            'Rata-rata Skor Dosen 2',
            'Saran untuk Dosen 2',
            'Saran Umum',
            'Tanggal Submit',
        ];
    }

    public function map($evaluation): array
    {
        static $no = 0;
        $no++;

        // Calculate average scores
        $avgScore1 = $evaluation->lecturer_1_id ? $evaluation->getAverageScoreForLecturer($evaluation->lecturer_1_id) : null;
        $avgScore2 = $evaluation->lecturer_2_id ? $evaluation->getAverageScoreForLecturer($evaluation->lecturer_2_id) : null;

        return [
            $no,
            $evaluation->student_nim,
            $evaluation->student_name,
            $evaluation->student_email,
            $evaluation->questionnaire->title ?? 'N/A',
            $evaluation->questionnaire->programStudi->name ?? 'N/A',
            'Semester ' . $evaluation->semester_taken,
            $evaluation->lecturer_count,
            $evaluation->lecturer1->name ?? 'N/A',
            $evaluation->attendance_lecturer_1 ?? 'N/A',
            $avgScore1 ? number_format($avgScore1, 2) : 'N/A',
            $evaluation->suggestion_lecturer_1 ?? 'N/A',
            $evaluation->lecturer2->name ?? 'N/A',
            $evaluation->attendance_lecturer_2 ?? 'N/A',
            $avgScore2 ? number_format($avgScore2, 2) : 'N/A',
            $evaluation->suggestion_lecturer_2 ?? 'N/A',
            $evaluation->general_suggestion ?? 'N/A',
            $evaluation->submitted_at ? $evaluation->submitted_at->format('d/m/Y H:i') : 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Data styling
        $highestRow = $sheet->getHighestRow();
        if ($highestRow > 1) {
            $sheet->getStyle('A2:R' . $highestRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true,
                ],
            ]);

            // Center align for specific columns
            $sheet->getStyle('A2:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
            $sheet->getStyle('G2:H' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Semester & Jumlah Dosen
            $sheet->getStyle('K2:K' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Avg Score 1
            $sheet->getStyle('O2:O' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Avg Score 2
        }

        return [];
    }

    public function title(): string
    {
        return 'Data Evaluasi EDOM';
    }
}

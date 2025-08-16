<?php
// app/Imports/ParentsStudentsImport.php - Versi Simple

namespace App\Imports;

use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ParentsStudentsImport implements ToCollection, WithHeadingRow
{
    private $importedCount = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Skip empty rows
                if (empty($row['nim_siswa']) || empty($row['nama_siswa']) || empty($row['nama_orang_tua'])) {
                    continue;
                }

                // Create or update student
                $student = Student::updateOrCreate(
                    ['nim' => $row['nim_siswa']],
                    [
                        'name' => $row['nama_siswa'],
                        'email' => $row['email_siswa'] ?? null,
                        'phone' => $row['telepon_siswa'] ?? null,
                        'gender' => strtoupper($row['jenis_kelamin'] ?? 'L'),
                        'birth_date' => $this->parseDate($row['tanggal_lahir'] ?? null),
                        'birth_place' => $row['tempat_lahir'] ?? null,
                        'address' => $row['alamat_siswa'] ?? null,
                        'program_studi' => $row['program_studi'] ?? null,
                        'semester' => $row['semester'] ?? null,
                        'status' => $row['status_siswa'] ?? 'aktif',
                        'tahun_masuk' => $this->parseYear($row['tahun_masuk'] ?? null),
                        'is_active' => true,
                    ]
                );

                // Create parent account
                $parent = ParentModel::updateOrCreate(
                    ['student_id' => $student->id],
                    [
                        'username' => $student->nim,
                        'password' => $this->generatePassword($student, $row),
                        'name' => $row['nama_orang_tua'],
                        'email' => $row['email_orang_tua'] ?? null,
                        'phone' => $row['telepon_orang_tua'] ?? null,
                        'relation' => strtolower($row['hubungan'] ?? 'ayah'),
                        'occupation' => $row['pekerjaan'] ?? null,
                        'address' => $row['alamat_orang_tua'] ?? $row['alamat_siswa'] ?? null,
                        'is_active' => true,
                    ]
                );

                $this->importedCount++;
            } catch (\Exception $e) {
                \Log::error("Import error", [
                    'error' => $e->getMessage(),
                    'row' => $row->toArray()
                ]);
                continue; // Skip error rows but continue importing
            }
        }
    }

    private function parseDate($dateString)
    {
        if (!$dateString) return null;

        try {
            // Handle Excel date numbers
            if (is_numeric($dateString)) {
                $unixDate = ($dateString - 25569) * 86400;
                return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
            }

            // Try different date formats
            $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'];

            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $dateString);
                    if ($date && $date->year > 1900 && $date->year < 2100) {
                        return $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseYear($yearString)
    {
        if (!$yearString) return null;

        $year = (int) $yearString;
        if ($year < 1900 || $year > 2100) return null;

        return $year;
    }

    private function generatePassword($student, $row)
    {
        $password = $student->nim . '123'; // Default

        if (isset($row['tanggal_lahir']) && $row['tanggal_lahir']) {
            $birthDate = $this->parseDate($row['tanggal_lahir']);
            if ($birthDate) {
                $date = Carbon::parse($birthDate);
                $password = $student->nim . $date->format('dmY');
            }
        }

        return $password;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }
}

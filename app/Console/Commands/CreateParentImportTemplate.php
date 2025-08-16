<?php
// app/Console/Commands/CreateParentImportTemplate.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CreateParentImportTemplate extends Command
{
    protected $signature = 'template:parent-import';
    protected $description = 'Create Excel template for parent import';

    public function handle()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $headers = [
            'A1' => 'nim_siswa',
            'B1' => 'nama_siswa',
            'C1' => 'email_siswa',
            'D1' => 'telepon_siswa',
            'E1' => 'jenis_kelamin',
            'F1' => 'tanggal_lahir',
            'G1' => 'tempat_lahir',
            'H1' => 'alamat_siswa',
            'I1' => 'program_studi',
            'J1' => 'semester',
            'K1' => 'status_siswa',
            'L1' => 'tahun_masuk',
            'M1' => 'nama_orang_tua',
            'N1' => 'email_orang_tua',
            'O1' => 'telepon_orang_tua',
            'P1' => 'hubungan',
            'Q1' => 'pekerjaan',
            'R1' => 'alamat_orang_tua',
        ];

        // Set headers
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style headers
        $headerRange = 'A1:R1';
        $sheet->getStyle($headerRange)->applyFromArray([
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
            ],
        ]);

        // Sample data
        $sampleData = [
            ['2023001', 'Ahmad Fauzi', 'ahmad@email.com', '08123456789', 'L', '15/01/2000', 'Jakarta', 'Jl. Merdeka No. 1', 'Teknik Informatika', '3', 'aktif', '2023', 'Budi Santoso', 'budi@email.com', '08198765432', 'ayah', 'Wiraswasta', 'Jl. Merdeka No. 1'],
            ['2023002', 'Siti Aminah', 'siti@email.com', '08123456790', 'P', '20/03/1999', 'Surabaya', 'Jl. Pahlawan No. 5', 'Manajemen', '5', 'aktif', '2023', 'Sari Dewi', 'sari@email.com', '08198765433', 'ibu', 'Guru', 'Jl. Pahlawan No. 5'],
            ['2023003', 'Muhammad Rizki', 'rizki@email.com', '08123456791', 'L', '10/07/2001', 'Bandung', 'Jl. Sudirman No. 10', 'Akuntansi', '1', 'aktif', '2023', 'Agus Wibowo', 'agus@email.com', '08198765434', 'wali', 'Pedagang', 'Jl. Sudirman No. 10'],
        ];

        // Add sample data
        $row = 2;
        foreach ($sampleData as $data) {
            $col = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'R') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Add validation for specific columns
        // Gender validation
        $validation = $sheet->getCell('E2')->getDataValidation();
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setFormula1('"L,P"');
        $validation->setShowDropDown(true);

        // Relation validation
        $validation = $sheet->getCell('P2')->getDataValidation();
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setFormula1('"ayah,ibu,wali"');
        $validation->setShowDropDown(true);

        // Status validation
        $validation = $sheet->getCell('K2')->getDataValidation();
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setFormula1('"aktif,cuti,lulus,DO"');
        $validation->setShowDropDown(true);

        // Create instructions sheet
        $instructionsSheet = $spreadsheet->createSheet();
        $instructionsSheet->setTitle('Petunjuk');

        $instructions = [
            ['PETUNJUK PENGGUNAAN TEMPLATE IMPORT ORANG TUA & SISWA'],
            [''],
            ['1. KOLOM WAJIB DIISI:'],
            ['   - nim_siswa: NIM siswa (unik, tidak boleh sama)'],
            ['   - nama_siswa: Nama lengkap siswa'],
            ['   - jenis_kelamin: L untuk Laki-laki, P untuk Perempuan'],
            ['   - nama_orang_tua: Nama lengkap orang tua/wali'],
            [''],
            ['2. KOLOM OPSIONAL:'],
            ['   - Semua kolom lainnya boleh dikosongkan'],
            ['   - tanggal_lahir: Format DD/MM/YYYY (contoh: 15/01/2000)'],
            ['   - hubungan: ayah, ibu, atau wali (default: ayah)'],
            ['   - status_siswa: aktif, cuti, lulus, atau DO (default: aktif)'],
            [''],
            ['3. AKUN YANG AKAN DIBUAT:'],
            ['   - Username: sama dengan NIM siswa'],
            ['   - Password: NIM + tanggal lahir (format: NIMddmmyyyy)'],
            ['   - Jika tanggal lahir kosong: NIM + 123'],
            [''],
            ['4. CONTOH PASSWORD:'],
            ['   - NIM: 2023001, Lahir: 15/01/2000'],
            ['   - Password: 202300115012000'],
            ['   - Jika tanggal lahir kosong: 2023001123'],
            [''],
            ['5. TIPS:'],
            ['   - Pastikan NIM unik untuk setiap siswa'],
            ['   - Gunakan format tanggal DD/MM/YYYY'],
            ['   - Jangan ubah nama kolom header'],
            ['   - Hapus baris contoh sebelum import data asli'],
        ];

        $row = 1;
        foreach ($instructions as $instruction) {
            $instructionsSheet->setCellValue('A' . $row, $instruction[0]);
            if ($row == 1) {
                $instructionsSheet->getStyle('A' . $row)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E5E7EB'],
                    ],
                ]);
            } elseif (strpos($instruction[0], '. ') !== false) {
                $instructionsSheet->getStyle('A' . $row)->applyFromArray([
                    'font' => ['bold' => true],
                ]);
            }
            $row++;
        }

        $instructionsSheet->getColumnDimension('A')->setWidth(60);

        // Save file
        $templatePath = storage_path('app/templates');
        if (!file_exists($templatePath)) {
            mkdir($templatePath, 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $templatePath . '/template_import_orang_tua.xlsx';
        $writer->save($filename);

        $this->info('Template Excel berhasil dibuat di: ' . $filename);
        return Command::SUCCESS;
    }
}

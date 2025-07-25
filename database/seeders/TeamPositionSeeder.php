<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamPosition;

class TeamPositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['name' => 'Dekan', 'level' => 1, 'description' => 'Pimpinan tertinggi fakultas'],
            ['name' => 'Wakil Dekan I', 'level' => 2, 'description' => 'Wakil Dekan bidang Akademik'],
            ['name' => 'Wakil Dekan II', 'level' => 2, 'description' => 'Wakil Dekan bidang Keuangan dan Umum'],
            ['name' => 'Wakil Dekan III', 'level' => 2, 'description' => 'Wakil Dekan bidang Kemahasiswaan'],
            ['name' => 'Ketua Program Studi', 'level' => 3, 'description' => 'Pimpinan program studi'],
            ['name' => 'Sekretaris Program Studi', 'level' => 4, 'description' => 'Sekretaris program studi'],
            ['name' => 'Profesor', 'level' => 5, 'description' => 'Guru Besar'],
            ['name' => 'Lektor Kepala', 'level' => 6, 'description' => 'Dosen senior'],
            ['name' => 'Lektor', 'level' => 7, 'description' => 'Dosen madya'],
            ['name' => 'Asisten Ahli', 'level' => 8, 'description' => 'Dosen muda'],
            ['name' => 'Tenaga Kependidikan', 'level' => 9, 'description' => 'Staff administrasi'],
        ];

        foreach ($positions as $position) {
            TeamPosition::create($position);
        }
    }
}

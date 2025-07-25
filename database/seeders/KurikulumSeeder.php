<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kurikulum;
use App\Models\ProgramStudi;

class KurikulumSeeder extends Seeder
{
    public function run(): void
    {
        $programStudis = ProgramStudi::all();

        foreach ($programStudis as $prodi) {
            // Create current curriculum
            Kurikulum::create([
                'prodi_id' => $prodi->id,
                'name' => 'Kurikulum ' . $prodi->name . ' 2024',
                'academic_year' => '2024/2025',
                'total_credits' => $prodi->degree_level === 'D3' ? 110 : ($prodi->degree_level === 'S1' ? 144 : ($prodi->degree_level === 'S2' ? 36 : 40)),
                'document_url' => '/documents/kurikulum-' . strtolower($prodi->code) . '-2024.pdf',
                'description' => 'Kurikulum terbaru yang disesuaikan dengan kebutuhan industri dan perkembangan teknologi',
                'is_active' => true,
            ]);

            // DON'T create mata kuliah here - let MataKuliahSeeder handle it
            // Remove: $this->createMataKuliah($kurikulum, $prodi);

            // Create previous curriculum for history
            Kurikulum::create([
                'prodi_id' => $prodi->id,
                'name' => 'Kurikulum ' . $prodi->name . ' 2020',
                'academic_year' => '2020/2021',
                'total_credits' => $prodi->degree_level === 'D3' ? 108 : ($prodi->degree_level === 'S1' ? 140 : ($prodi->degree_level === 'S2' ? 34 : 38)),
                'document_url' => '/documents/kurikulum-' . strtolower($prodi->code) . '-2020.pdf',
                'description' => 'Kurikulum periode 2020-2024',
                'is_active' => false,
            ]);
        }
    }

    // Remove all the createMataKuliah methods since MataKuliahSeeder will handle it
    // private function createMataKuliah($kurikulum, $prodi) { ... } - DELETE THIS METHOD
}

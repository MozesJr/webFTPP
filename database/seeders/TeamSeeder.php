<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\TeamPosition;
use App\Models\ProgramStudi;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $dekanPosition = TeamPosition::where('name', 'Dekan')->first();
        $wadekPositions = TeamPosition::where('name', 'like', 'Wakil Dekan%')->get();
        $kaprodiPosition = TeamPosition::where('name', 'Ketua Program Studi')->first();
        $profesorPosition = TeamPosition::where('name', 'Profesor')->first();
        $lektorPosition = TeamPosition::where('name', 'Lektor')->first();

        $programStudis = ProgramStudi::all();

        // Leadership Team
        Team::create([
            'name' => 'Prof. Dr. Ir. Bambang Supriyanto, M.Sc.',
            'position_id' => $dekanPosition->id,
            'prodi_id' => null,
            'email' => 'dekan@fti.ac.id',
            'phone' => '+62 21 7918 1240',
            'bio' => 'Profesor dengan pengalaman 25 tahun di bidang teknologi informasi. Memiliki fokus penelitian pada artificial intelligence dan machine learning.',
            'photo_url' => 'https://randomuser.me/api/portraits/men/1.jpg',
            'education' => 'S1: Teknik Elektro ITB (1985), S2: Computer Science Stanford University (1990), S3: Computer Science MIT (1995)',
            'expertise' => 'Artificial Intelligence, Machine Learning, Data Mining, Computer Vision',
            'is_active' => true,
            'order_index' => 1,
        ]);

        Team::create([
            'name' => 'Dr. Siti Nurhaliza, M.Kom.',
            'position_id' => $wadekPositions->where('name', 'Wakil Dekan I')->first()->id,
            'prodi_id' => null,
            'email' => 'wadek1@fti.ac.id',
            'phone' => '+62 21 7918 1241',
            'bio' => 'Wakil Dekan I bidang Akademik dengan fokus pada pengembangan kurikulum dan quality assurance.',
            'photo_url' => 'https://randomuser.me/api/portraits/women/1.jpg',
            'education' => 'S1: Teknik Informatika UI (1995), S2: Sistem Informasi UGM (2000), S3: Computer Science USU (2008)',
            'expertise' => 'Software Engineering, Database Systems, Information Systems',
            'is_active' => true,
            'order_index' => 2,
        ]);

        // Program Studi Heads
        $tifProdi = $programStudis->where('code', 'TIF')->first();
        Team::create([
            'name' => 'Dr. Budi Santoso, M.Kom.',
            'position_id' => $kaprodiPosition->id,
            'prodi_id' => $tifProdi->id,
            'email' => 'kaprodi.tif@fti.ac.id',
            'phone' => '+62 21 7918 1250',
            'bio' => 'Ketua Program Studi Teknik Informatika dengan pengalaman 15 tahun dalam pengembangan software dan penelitian AI.',
            'photo_url' => 'https://randomuser.me/api/portraits/men/2.jpg',
            'education' => 'S1: Teknik Informatika ITS (1998), S2: Computer Science UGM (2003), S3: Computer Science UI (2010)',
            'expertise' => 'Software Engineering, Web Development, Mobile Programming, AI',
            'is_active' => true,
            'order_index' => 1,
        ]);

        $sifProdi = $programStudis->where('code', 'SIF')->first();
        Team::create([
            'name' => 'Dr. Sari Indrawati, M.SI.',
            'position_id' => $kaprodiPosition->id,
            'prodi_id' => $sifProdi->id,
            'email' => 'kaprodi.sif@fti.ac.id',
            'phone' => '+62 21 7918 1251',
            'bio' => 'Ketua Program Studi Sistem Informasi dengan spesialisasi dalam business intelligence dan enterprise systems.',
            'photo_url' => 'https://randomuser.me/api/portraits/women/2.jpg',
            'education' => 'S1: Sistem Informasi Binus (2000), S2: Manajemen Sistem Informasi UI (2005), S3: Information Systems UGM (2012)',
            'expertise' => 'Business Intelligence, Enterprise Systems, Data Analytics, Project Management',
            'is_active' => true,
            'order_index' => 1,
        ]);

        // Faculty Members
        $facultyMembers = [
            [
                'name' => 'Prof. Dr. Ahmad Dahlan, M.T.',
                'position_id' => $profesorPosition->id,
                'prodi_id' => $tifProdi->id,
                'email' => 'ahmad.dahlan@fti.ac.id',
                'expertise' => 'Network Security, Cryptography, Cybersecurity',
                'photo_url' => 'https://randomuser.me/api/portraits/men/3.jpg',
            ],
            [
                'name' => 'Dr. Maya Sari, M.Kom.',
                'position_id' => $lektorPosition->id,
                'prodi_id' => $tifProdi->id,
                'email' => 'maya.sari@fti.ac.id',
                'expertise' => 'Human-Computer Interaction, UI/UX Design, Mobile Development',
                'photo_url' => 'https://randomuser.me/api/portraits/women/3.jpg',
            ],
            [
                'name' => 'Dr. Rudi Hartono, M.T.',
                'position_id' => $lektorPosition->id,
                'prodi_id' => $sifProdi->id,
                'email' => 'rudi.hartono@fti.ac.id',
                'expertise' => 'Database Management, Big Data, Data Warehousing',
                'photo_url' => 'https://randomuser.me/api/portraits/men/4.jpg',
            ],
            [
                'name' => 'Dr. Rina Kusuma, M.SI.',
                'position_id' => $lektorPosition->id,
                'prodi_id' => $sifProdi->id,
                'email' => 'rina.kusuma@fti.ac.id',
                'expertise' => 'Business Process Management, ERP Systems, Digital Transformation',
                'photo_url' => 'https://randomuser.me/api/portraits/women/4.jpg',
            ],
        ];

        foreach ($facultyMembers as $index => $member) {
            Team::create(array_merge($member, [
                'phone' => '+62 21 7918 ' . (1260 + $index),
                'bio' => 'Dosen berpengalaman dengan fokus penelitian di bidang ' . $member['expertise'],
                'education' => 'S1, S2, S3 di bidang terkait',
                'is_active' => true,
                'order_index' => $index + 10,
            ]));
        }
    }
}

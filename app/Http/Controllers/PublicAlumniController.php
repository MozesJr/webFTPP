<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PublicAlumniController extends Controller
{
    public function index(): Response
    {
        // Data statis dummy
        $statistics = [
            'total_alumni' => 3450,
            'employed_alumni' => 3120,
            'entrepreneur_alumni' => 180,
            'postgraduate_alumni' => 150,
            'employment_rate' => 90.4, // persentase
        ];

        $featuredAlumni = [
            [
                'id' => 1,
                'nim' => '1801010001',
                'name' => 'Dr. Ir. Ahmad Fauzi, M.T.',
                'program_studi' => 'Teknik Perminyakan',
                'graduation_year' => 2010,
                'current_job' => 'Senior Petroleum Engineer',
                'company' => 'PT Pertamina Hulu Energi',
                'position' => 'Chief Reservoir Engineer',
                'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
                'testimonial' => 'FTPP UNIPA memberikan fondasi yang kuat dalam karir saya di industri migas. Ilmu yang didapat sangat aplikatif dan relevan dengan kebutuhan industri.',
                'achievements' => 'SPE Distinguished Lecturer 2023',
                'linkedin_url' => 'https://linkedin.com/in/ahmad-fauzi',
            ],
            [
                'id' => 2,
                'nim' => '1701020015',
                'name' => 'Ir. Sarah Wijaya, M.Sc.',
                'program_studi' => 'Teknik Pertambangan',
                'graduation_year' => 2012,
                'current_job' => 'Mining Manager',
                'company' => 'PT Freeport Indonesia',
                'position' => 'Operations Manager',
                'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
                'testimonial' => 'Pengalaman kuliah di FTPP sangat membantu saya dalam menghadapi tantangan di dunia pertambangan. Dosen-dosen yang kompeten dan fasilitas laboratorium yang memadai.',
                'achievements' => 'Woman in Mining Award 2022',
                'linkedin_url' => 'https://linkedin.com/in/sarah-wijaya',
            ],
            [
                'id' => 3,
                'nim' => '1601030008',
                'name' => 'Budi Hermawan, S.T., M.T.',
                'program_studi' => 'Teknik Geologi',
                'graduation_year' => 2011,
                'current_job' => 'Senior Geologist',
                'company' => 'PT Antam Tbk',
                'position' => 'Exploration Geologist',
                'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
                'testimonial' => 'Kurikulum yang up-to-date dan praktikum lapangan yang intensif membuat saya siap bekerja langsung setelah lulus.',
                'achievements' => 'Best Exploration Project 2021',
                'linkedin_url' => 'https://linkedin.com/in/budi-hermawan',
            ],
        ];

        $allAlumni = [
            [
                'id' => 4,
                'nim' => '1901010010',
                'name' => 'Rina Kusuma',
                'program_studi' => 'Teknik Perminyakan',
                'graduation_year' => 2023,
                'current_job' => 'Production Engineer',
                'company' => 'PT Medco Energi',
                'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
            ],
            [
                'id' => 5,
                'nim' => '1801020025',
                'name' => 'Andi Pratama',
                'program_studi' => 'Teknik Pertambangan',
                'graduation_year' => 2022,
                'current_job' => 'Mine Planner',
                'company' => 'PT Vale Indonesia',
                'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
            ],
            [
                'id' => 6,
                'nim' => '1701030012',
                'name' => 'Dewi Lestari',
                'program_studi' => 'Teknik Geologi',
                'graduation_year' => 2021,
                'current_job' => 'Geologist',
                'company' => 'PT Adaro Energy',
                'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
            ],
            [
                'id' => 7,
                'nim' => '1801010035',
                'name' => 'Fajar Nugroho',
                'program_studi' => 'Teknik Perminyakan',
                'graduation_year' => 2022,
                'current_job' => 'Drilling Engineer',
                'company' => 'Schlumberger',
                'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
            ],
            [
                'id' => 8,
                'nim' => '1701020040',
                'name' => 'Mega Putri',
                'program_studi' => 'Teknik Pertambangan',
                'graduation_year' => 2020,
                'current_job' => 'Environmental Engineer',
                'company' => 'PT Bukit Asam',
                'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
            ],
        ];

        $graduationYears = [2024, 2023, 2022, 2021, 2020, 2019, 2018];

        $programStudis = [
            ['id' => 1, 'name' => 'Teknik Perminyakan'],
            ['id' => 2, 'name' => 'Teknik Pertambangan'],
            ['id' => 3, 'name' => 'Teknik Geologi'],
        ];

        return Inertia::render('Public/Alumni/Index', [
            'statistics' => $statistics,
            'featuredAlumni' => $featuredAlumni,
            'allAlumni' => $allAlumni,
            'graduationYears' => $graduationYears,
            'programStudis' => $programStudis,
        ]);
    }

    public function show($id): Response
    {
        // Detail alumni statis
        $alumni = [
            'id' => 1,
            'nim' => '1801010001',
            'name' => 'Dr. Ir. Ahmad Fauzi, M.T.',
            'program_studi' => 'Teknik Perminyakan',
            'graduation_year' => 2010,
            'ipk' => 3.85,
            'current_job' => 'Senior Petroleum Engineer',
            'company' => 'PT Pertamina Hulu Energi',
            'position' => 'Chief Reservoir Engineer',
            'email' => 'ahmad.fauzi@pertamina.com',
            'phone' => '+62812345678',
            'photo' => 'https://img.freepik.com/premium-vector/man-professional-business-casual-young-avatar-icon-illustration_1277826-617.jpg?semt=ais_hybrid&w=740&q=80',
            'testimonial' => 'FTPP UNIPA memberikan fondasi yang kuat dalam karir saya di industri migas. Ilmu yang didapat sangat aplikatif dan relevan dengan kebutuhan industri. Pengalaman praktikum dan penelitian sangat membantu dalam menghadapi tantangan di lapangan.',
            'achievements' => [
                'SPE Distinguished Lecturer 2023',
                'Best Paper Award - SPE Asia Pacific Conference 2022',
                'Outstanding Young Engineer Award 2020',
            ],
            'linkedin_url' => 'https://linkedin.com/in/ahmad-fauzi',
            'instagram_url' => 'https://instagram.com/ahmadfauzi',
            'career_history' => [
                [
                    'year' => '2010-2013',
                    'position' => 'Junior Petroleum Engineer',
                    'company' => 'PT Pertamina EP',
                ],
                [
                    'year' => '2013-2018',
                    'position' => 'Reservoir Engineer',
                    'company' => 'PT Pertamina Hulu Energi',
                ],
                [
                    'year' => '2018-Present',
                    'position' => 'Chief Reservoir Engineer',
                    'company' => 'PT Pertamina Hulu Energi',
                ],
            ],
        ];

        return Inertia::render('Public/Alumni/Show', [
            'alumni' => $alumni,
        ]);
    }
}

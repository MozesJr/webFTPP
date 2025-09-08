<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Stats;
use App\Models\Team;
use App\Models\TeamPosition;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\SiteSetting;
use App\Models\ProgramStudi;

class AboutController extends Controller
{
    /**
     * Display main about navigation page
     */
    public function index(): Response
    {
        $data = [
            'stats' => Stats::current()->first(),
        ];

        return Inertia::render('About/Index', $data);
    }

    /**
     * Display faculty profile page
     */
    public function profile(): Response
    {
        $data = [
            'about' => About::active()->first(),
        ];

        return Inertia::render('About/Profile', $data);
    }

    /**
     * Display vision and mission page
     */
    public function visionMission(): Response
    {
        $data = [
            'about' => About::active()->first(),
            'tujuan' => SiteSetting::getFormattedValue('tujuan', ''), // Optional: jika ada tujuan di site settings
        ];

        return Inertia::render('About/VisionMission', $data);
    }

    /**
     * Display faculty history page
     */
    public function history(): Response
    {
        $data = [
            'sejarah' => SiteSetting::getFormattedValue('sejarah', ''),
            'milestones' => $this->getDefaultMilestones(),
            'milestoneDetails' => $this->getMilestoneDetails(),
            'historyImages' => $this->getHistoryImages(),
        ];

        return Inertia::render('About/History', $data);
    }

    /**
     * Display program studi page
     */
    public function programStudi(): Response
    {
        $data = [
            'programStudis' => $this->getProgramStudiGrouped(),
        ];

        return Inertia::render('About/ProgramStudi', $data);
    }

    /**
     * Display accreditation page
     */
    public function accreditation(): Response
    {
        $data = [
            'programStudi' => ProgramStudi::active()
                ->select([
                    'id',
                    'name',
                    'code',
                    'degree_level',
                    'accreditation',
                    'accreditation_date',
                    'accreditation_expire',
                    'certificate_url' // Jika ada field untuk sertifikat
                ])
                ->orderBy('degree_level')
                ->orderBy('name')
                ->get(),
        ];

        return Inertia::render('About/Accreditation', $data);
    }

    /**
     * Display leadership and staff page
     */
    public function leadership(): Response
    {
        $data = [
            // LEADERSHIP: Ambil team dengan position level <= 3 (Dekan, Wakil Dekan, Kaprodi)
            'leadership' => Team::active()
                ->with(['position', 'programStudi'])
                ->whereHas('position', function ($query) {
                    $query->where('level', '<=', 3); // Top 3 levels for leadership
                })
                ->ordered()
                ->get()
                ->groupBy('position.name'), // Group berdasarkan nama posisi

            // FACULTY: Ambil team dengan position level > 3 (Dosen, Staff)
            'faculty' => Team::active()
                ->with(['position', 'programStudi'])
                ->whereHas('position', function ($query) {
                    $query->where('level', '>', 3); // Lower levels for faculty
                })
                ->ordered()
                ->get()
                ->groupBy('programStudi.name'), // Group berdasarkan nama program studi

            'stats' => Stats::current()->first(),
        ];

        return Inertia::render('About/Leadership', $data);
    }

    /**
     * Get program studi grouped by degree level
     */
    private function getProgramStudiGrouped()
    {
        return ProgramStudi::active()
            ->select([
                'id',
                'name',
                'code',
                'degree_level',
                'description',
                'overview',
                'image_url',
                'accreditation',
                'head_of_program',
                'established_year'
            ])
            ->orderBy('degree_level')
            ->orderBy('name')
            ->get()
            ->groupBy('degree_level')
            ->map(function ($programs) {
                return $programs->map(function ($prodi) {
                    return [
                        'id' => $prodi->id,
                        'name' => $prodi->name,
                        'code' => $prodi->code,
                        'degree_level' => $prodi->degree_level,
                        'description' => $prodi->description,
                        'overview' => $prodi->overview,
                        'image_url' => $prodi->image_url,
                        'accreditation' => $prodi->accreditation ?? '-',
                        'head_of_program' => $prodi->head_of_program,
                        'established_year' => $prodi->established_year
                    ];
                });
            });
    }

    /**
     * Get default milestones (you can move this to database later)
     */
    private function getDefaultMilestones()
    {
        // Coba ambil dari database terlebih dahulu, jika tidak ada gunakan default
        $milestones = SiteSetting::getFormattedValue('milestones', null);

        if ($milestones) {
            return json_decode($milestones, true);
        }

        // Default milestones
        return [
            ['year' => '1985', 'event' => 'Pendirian Fakultas Teknik Pertambangan'],
            ['year' => '1992', 'event' => 'Pembukaan Program Studi Teknik Perminyakan'],
            ['year' => '2005', 'event' => 'Pembukaan Program Studi Teknik Geologi'],
            ['year' => '2010', 'event' => 'Memperoleh Akreditasi A dari BAN-PT'],
            ['year' => '2015', 'event' => 'Pembukaan Program Magister Teknik Pertambangan'],
            ['year' => '2020', 'event' => 'Pembukaan Program Doktor Teknik Pertambangan'],
        ];
    }

    /**
     * Get detailed milestones (you can move this to database later)
     */
    private function getMilestoneDetails()
    {
        // Coba ambil dari database terlebih dahulu
        $milestoneDetails = SiteSetting::getFormattedValue('milestone_details', null);

        if ($milestoneDetails) {
            return json_decode($milestoneDetails, true);
        }

        // Default milestone details
        return [
            [
                'year' => '1985',
                'title' => 'Pendirian Fakultas',
                'description' => 'Fakultas Teknik Pertambangan Perminyakan didirikan sebagai bagian dari komitmen Universitas Papua untuk mengembangkan sumber daya alam Papua.'
            ],
            [
                'year' => '1992',
                'title' => 'Ekspansi Program',
                'description' => 'Pembukaan Program Studi Teknik Perminyakan untuk memenuhi kebutuhan industri energi di Indonesia Timur.'
            ],
            [
                'year' => '2005',
                'title' => 'Diversifikasi Keilmuan',
                'description' => 'Program Studi Teknik Geologi dibuka untuk memperkuat basis keilmuan geosains di Papua.'
            ],
            [
                'year' => '2010',
                'title' => 'Pengakuan Kualitas',
                'description' => 'Memperoleh Akreditasi A dari BAN-PT sebagai pengakuan atas kualitas pendidikan yang diberikan.'
            ],
            [
                'year' => '2015',
                'title' => 'Pendidikan Pascasarjana',
                'description' => 'Pembukaan Program Magister Teknik Pertambangan untuk menghasilkan ahli tingkat lanjut.'
            ],
            [
                'year' => '2020',
                'title' => 'Pusat Penelitian',
                'description' => 'Program Doktor dibuka untuk memperkuat riset dan pengembangan ilmu pengetahuan.'
            ],
        ];
    }

    /**
     * Get history images (you can move this to database later)
     */
    private function getHistoryImages()
    {
        // Coba ambil dari database terlebih dahulu
        $historyImages = SiteSetting::getFormattedValue('history_images', null);

        if ($historyImages) {
            return json_decode($historyImages, true);
        }

        // Return empty array or default images
        return [];
    }
}

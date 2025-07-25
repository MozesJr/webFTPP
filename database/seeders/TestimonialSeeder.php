<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\ProgramStudi;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $programStudis = ProgramStudi::all();

        $testimonials = [
            [
                'name' => 'Sarah Michelle',
                'position' => 'Software Engineer',
                'company' => 'Google Indonesia',
                'content' => 'Pendidikan di Fakultas TI memberikan foundation yang sangat kuat dalam programming dan software development. Kurikulumnya sangat up-to-date dengan kebutuhan industri.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/10.jpg',
                'rating' => 5,
                'type' => 'alumni',
                'prodi' => 'TIF',
                'is_featured' => true,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'position' => 'Data Scientist',
                'company' => 'Tokopedia',
                'content' => 'Program Sistem Informasi di FTI tidak hanya mengajarkan teknologi, tapi juga business process yang sangat valuable di dunia kerja. Terima kasih untuk semua ilmu yang diberikan.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/10.jpg',
                'rating' => 5,
                'type' => 'alumni',
                'prodi' => 'SIF',
                'is_featured' => true,
            ],
            [
                'name' => 'Jessica Tan',
                'position' => 'UI/UX Designer',
                'company' => 'Gojek',
                'content' => 'Dosen-dosen di FTI sangat supportive dan selalu mendorong mahasiswa untuk berkembang. Lab dan fasilitasnya juga lengkap untuk praktikum.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/11.jpg',
                'rating' => 5,
                'type' => 'student',
                'prodi' => 'TIF',
                'is_featured' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'position' => 'IT Manager',
                'company' => 'Bank BCA',
                'content' => 'Lulusan FTI yang bekerja di perusahaan kami selalu menunjukkan performa yang excellent. Mereka memiliki technical skill dan soft skill yang baik.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/11.jpg',
                'rating' => 5,
                'type' => 'industry',
                'prodi' => null,
                'is_featured' => false,
            ],
            [
                'name' => 'Maria Gonzales',
                'position' => 'Network Administrator',
                'company' => 'PT. Telkom Indonesia',
                'content' => 'Program D3 TI sangat praktis dan langsung applicable di dunia kerja. Setelah lulus langsung bisa kerja tanpa perlu training tambahan yang lama.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/12.jpg',
                'rating' => 4,
                'type' => 'alumni',
                'prodi' => 'TI',
                'is_featured' => false,
            ],
            [
                'name' => 'Dr. Hendro Wicaksono',
                'position' => 'Research Scientist',
                'company' => 'Microsoft Research',
                'content' => 'Program S2 di FTI memberikan kesempatan untuk melakukan riset yang berkualitas tinggi dengan guidance dari supervisor yang expert di bidangnya.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/12.jpg',
                'rating' => 5,
                'type' => 'alumni',
                'prodi' => 'MTI',
                'is_featured' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            $prodi = null;
            if ($testimonial['prodi']) {
                $prodi = $programStudis->where('code', $testimonial['prodi'])->first();
            }

            Testimonial::create([
                'name' => $testimonial['name'],
                'position' => $testimonial['position'],
                'company' => $testimonial['company'],
                'content' => $testimonial['content'],
                'photo_url' => $testimonial['photo_url'],
                'rating' => $testimonial['rating'],
                'prodi_id' => $prodi?->id,
                'type' => $testimonial['type'],
                'is_active' => true,
                'is_featured' => $testimonial['is_featured'],
            ]);
        }
    }
}

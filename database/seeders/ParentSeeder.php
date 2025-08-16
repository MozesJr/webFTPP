<?php
// database/seeders/ParentSeeder.php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ParentSeeder extends Seeder
{
    public function run()
    {
        // Get all students
        $students = Student::all();

        foreach ($students as $student) {
            // Create parent for each student
            $parent = ParentModel::create([
                'student_id' => $student->id,
                'username' => $student->nim,
                'password' => Hash::make($this->generatePassword($student)),
                'name' => 'Orang Tua ' . $student->name,
                'email' => 'parent.' . $student->nim . '@example.com',
                'phone' => '08' . rand(1000000000, 9999999999),
                'relation' => ['ayah', 'ibu', 'wali'][rand(0, 2)],
                'occupation' => ['PNS', 'Wiraswasta', 'Karyawan Swasta', 'Guru', 'Dokter'][rand(0, 4)],
                'address' => 'Alamat Orang Tua ' . $student->name,
                'is_active' => true,
            ]);

            $this->command->info("Created parent for student: {$student->nim} - {$student->name}");
        }
    }

    private function generatePassword($student)
    {
        // Password: NIM + birth_date (ddmmyyyy) or default
        $password = $student->nim;
        if ($student->birth_date) {
            $password .= $student->birth_date->format('dmY');
        } else {
            $password .= '01012000'; // default
        }
        return $password;
    }
}

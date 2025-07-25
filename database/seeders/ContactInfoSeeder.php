<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            // Address
            ['type' => 'address', 'label' => 'Alamat Kampus', 'value' => 'Jl. Pendidikan No. 123, Jakarta Selatan 12950, Indonesia', 'icon' => 'map-pin', 'order_index' => 1],

            // Phone numbers
            ['type' => 'phone', 'label' => 'Telepon Utama', 'value' => '+62 21 7918 1234', 'icon' => 'phone', 'order_index' => 1],
            ['type' => 'phone', 'label' => 'Admisi', 'value' => '+62 21 7918 1235', 'icon' => 'phone', 'order_index' => 2],
            ['type' => 'fax', 'label' => 'Fax', 'value' => '+62 21 7918 1236', 'icon' => 'printer', 'order_index' => 3],

            // Email addresses
            ['type' => 'email', 'label' => 'Email Umum', 'value' => 'info@fti.ac.id', 'icon' => 'envelope', 'order_index' => 1],
            ['type' => 'email', 'label' => 'Admisi', 'value' => 'admisi@fti.ac.id', 'icon' => 'envelope', 'order_index' => 2],
            ['type' => 'email', 'label' => 'Akademik', 'value' => 'akademik@fti.ac.id', 'icon' => 'envelope', 'order_index' => 3],

            // Social Media
            ['type' => 'social_media', 'label' => 'Facebook', 'value' => 'https://facebook.com/fti.university', 'icon' => 'facebook', 'order_index' => 1],
            ['type' => 'social_media', 'label' => 'Instagram', 'value' => 'https://instagram.com/fti_university', 'icon' => 'instagram', 'order_index' => 2],
            ['type' => 'social_media', 'label' => 'YouTube', 'value' => 'https://youtube.com/@fti-university', 'icon' => 'youtube', 'order_index' => 3],
            ['type' => 'social_media', 'label' => 'LinkedIn', 'value' => 'https://linkedin.com/school/fti-university', 'icon' => 'linkedin', 'order_index' => 4],

            // Website
            ['type' => 'website', 'label' => 'Website Utama', 'value' => 'https://fti.ac.id', 'icon' => 'globe', 'order_index' => 1],
        ];

        foreach ($contacts as $contact) {
            ContactInfo::create(array_merge($contact, ['is_active' => true]));
        }
    }
}

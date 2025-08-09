<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key_name' => 'site_title', 'value' => 'Fakultas Teknologi Informasi', 'type' => 'text', 'group' => 'general'],
            ['key_name' => 'site_description', 'value' => 'Fakultas Teknologi Informasi - Universitas Terdepan dalam Pendidikan IT', 'type' => 'text', 'group' => 'general'],
            ['key_name' => 'site_logo', 'value' => '/images/Logo_Universitas_Papua.png', 'type' => 'file', 'group' => 'general'],
            ['key_name' => 'favicon', 'value' => '/images/favicon.ico', 'type' => 'file', 'group' => 'general'],

            // Contact Information
            ['key_name' => 'contact_email', 'value' => 'info@fti.ac.id', 'type' => 'email', 'group' => 'contact'],
            ['key_name' => 'contact_phone', 'value' => '+62 21 7918 1234', 'type' => 'text', 'group' => 'contact'],
            ['key_name' => 'contact_fax', 'value' => '+62 21 7918 1235', 'type' => 'text', 'group' => 'contact'],
            ['key_name' => 'address', 'value' => 'Jl. Pendidikan No. 123, Jakarta Selatan 12950, Indonesia', 'type' => 'textarea', 'group' => 'contact'],

            // Social Media
            ['key_name' => 'facebook_url', 'value' => 'https://facebook.com/fti.university', 'type' => 'url', 'group' => 'social'],
            ['key_name' => 'instagram_url', 'value' => 'https://instagram.com/fti_university', 'type' => 'url', 'group' => 'social'],
            ['key_name' => 'youtube_url', 'value' => 'https://youtube.com/@fti-university', 'type' => 'url', 'group' => 'social'],
            ['key_name' => 'linkedin_url', 'value' => 'https://linkedin.com/school/fti-university', 'type' => 'url', 'group' => 'social'],

            // SEO Settings
            ['key_name' => 'meta_keywords', 'value' => 'fakultas, teknologi informasi, universitas, pendidikan, IT, komputer', 'type' => 'text', 'group' => 'seo'],
            ['key_name' => 'google_analytics_id', 'value' => 'G-XXXXXXXXXX', 'type' => 'text', 'group' => 'seo'],

            // Appearance
            ['key_name' => 'theme_color', 'value' => '#3B82F6', 'type' => 'color', 'group' => 'appearance'],
            ['key_name' => 'items_per_page', 'value' => '12', 'type' => 'number', 'group' => 'general'],

            // Features
            ['key_name' => 'enable_news', 'value' => '1', 'type' => 'boolean', 'group' => 'features'],
            ['key_name' => 'enable_events', 'value' => '1', 'type' => 'boolean', 'group' => 'features'],
            ['key_name' => 'enable_gallery', 'value' => '1', 'type' => 'boolean', 'group' => 'features'],
            ['key_name' => 'enable_testimonials', 'value' => '1', 'type' => 'boolean', 'group' => 'features'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}

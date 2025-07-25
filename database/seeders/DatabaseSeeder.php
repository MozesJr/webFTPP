<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Base data
            RolePermissionSeeder::class,
            UserSeeder::class,

            // Site configuration
            SiteSettingSeeder::class,
            HeroSectionSeeder::class,
            AboutSeeder::class,
            StatsSeeder::class,
            ContactInfoSeeder::class,

            // Academic structure
            TeamPositionSeeder::class,
            ProgramStudiSeeder::class,
            TeamSeeder::class,
            KurikulumSeeder::class,
            MataKuliahSeeder::class,

            // Content
            NewsCategorySeeder::class,
            NewsSeeder::class,
            ClientSeeder::class,
            TestimonialSeeder::class,
            GallerySeeder::class,
            EventSeeder::class,
        ]);
    }
}

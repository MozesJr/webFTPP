<?php

namespace Database\Seeders;

use App\Models\DeanGreeting;
use Illuminate\Database\Seeder;

class DeanGreetingSeeder extends Seeder
{
    public function run(): void
    {
        DeanGreeting::create([
            'section_title' => 'Sambutan',
            'section_subtitle' => 'Dekan FTPP UNIPA',
            'greeting_text' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id at quas cumque provident esse recusandae inventore amet eius ea perferendis, officia placeat saepe. Molestias, illum. Voluptas architecto repellat illum amet dolor eligendi, ducimus dolores tempore. Dolore sequi tenetur atque nostrum. Totam dolores, recusandae tenetur repellat, obcaecati aperiam incidunt provident officia culpa, facilis placeat cupiditate perferendis minus.',
            'dean_name' => 'Eko A. Martanto',
            'dean_title' => 'Prof. Dr. Ir.',
            'dean_degree' => 'MP',
            'dean_photo' => 'assets/img/team1.png',
            'is_active' => true,
            'display_order' => 1,
        ]);
    }
}

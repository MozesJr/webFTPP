<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'PT. Telkom Indonesia',
                'logo_url' => 'https://via.placeholder.com/200x100/0066CC/FFFFFF?text=TELKOM',
                'website_url' => 'https://telkom.co.id',
                'partnership_type' => 'Industri Partner',
                'description' => 'Kerjasama dalam program magang dan penelitian telekomunikasi',
            ],
            [
                'name' => 'Bank Central Asia',
                'logo_url' => 'https://via.placeholder.com/200x100/003366/FFFFFF?text=BCA',
                'website_url' => 'https://bca.co.id',
                'partnership_type' => 'Recruitment Partner',
                'description' => 'Rekrutmen lulusan untuk divisi IT dan digital banking',
            ],
            [
                'name' => 'PT. Gojek Indonesia',
                'logo_url' => 'https://via.placeholder.com/200x100/00AA13/FFFFFF?text=GOJEK',
                'website_url' => 'https://gojek.com',
                'partnership_type' => 'Startup Partner',
                'description' => 'Kolaborasi dalam pengembangan teknologi dan inovasi digital',
            ],
            [
                'name' => 'Microsoft Indonesia',
                'logo_url' => 'https://via.placeholder.com/200x100/00BCF2/FFFFFF?text=MICROSOFT',
                'website_url' => 'https://microsoft.com/id-id',
                'partnership_type' => 'Technology Partner',
                'description' => 'Program sertifikasi dan lisensi software untuk pendidikan',
            ],
            [
                'name' => 'PT. Tokopedia',
                'logo_url' => 'https://via.placeholder.com/200x100/42B549/FFFFFF?text=TOKOPEDIA',
                'website_url' => 'https://tokopedia.com',
                'partnership_type' => 'E-commerce Partner',
                'description' => 'Penelitian bersama dalam bidang e-commerce dan fintech',
            ],
            [
                'name' => 'Oracle Indonesia',
                'logo_url' => 'https://via.placeholder.com/200x100/FF0000/FFFFFF?text=ORACLE',
                'website_url' => 'https://oracle.com/id',
                'partnership_type' => 'Database Partner',
                'description' => 'Program pelatihan database dan cloud computing',
            ],
        ];

        foreach ($clients as $index => $client) {
            Client::create(array_merge($client, [
                'is_active' => true,
                'order_index' => $index + 1,
            ]));
        }
    }
}

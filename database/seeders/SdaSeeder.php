<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sda;

class SdaSeeder extends Seeder
{
    public function run(): void
    {
        Sda::create([
            'title' => 'Sawah Produktif Palembang',
            'description' => 'Area pertanian padi yang luas dan subur.',
            'location' => 'Seberang Ulu',
            'category_id' => 1
        ]);

        Sda::create([
            'title' => 'Hutan Lindung',
            'description' => 'Kawasan hutan yang dilindungi pemerintah.',
            'location' => 'Bukit Siguntang',
            'category_id' => 2
        ]);

        Sda::create([
            'title' => 'Sungai Musi',
            'description' => 'Sumber daya air utama di Palembang.',
            'location' => 'Kota Palembang',
            'category_id' => 8
        ]);
    }
}
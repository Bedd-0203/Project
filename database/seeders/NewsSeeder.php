<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::create([
            'title' => 'Potensi SDA Palembang Meningkat',
            'content' => 'Pemerintah meningkatkan pengelolaan SDA.',
            'user_id' => 1
        ]);

        News::create([
            'title' => 'Pengelolaan Sungai Musi',
            'content' => 'Program kebersihan dan konservasi sungai.',
            'user_id' => 1
        ]);
    }
}
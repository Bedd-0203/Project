<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Pertanian',
            'Kehutanan',
            'Kelautan',
            'Perikanan',
            'Pertambangan',
            'Lingkungan Hidup',
            'Energi',
            'Air'
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat
            ]);
        }
    }
}
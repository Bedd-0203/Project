<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        Report::create([
            'user_id' => 3,
            'title' => 'Pencemaran Sungai',
            'description' => 'Air sungai terlihat kotor dan berbau.',
            'status' => 'pending'
        ]);

        Report::create([
            'user_id' => 3,
            'title' => 'Penebangan Liar',
            'description' => 'Ada aktivitas ilegal di hutan.',
            'status' => 'diproses'
        ]);
    }
}
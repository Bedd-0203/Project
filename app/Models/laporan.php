<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'image',
        'status',
        'response'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id'
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sda extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'image',
        'category_id'
    ];

    // RELASI KE CATEGORY
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'judul',
        'penulis',
        'kategori_id',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'kategori_id');
    }
}

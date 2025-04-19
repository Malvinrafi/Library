<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'tahun_terbit',
        'category',
        'book_cover',
        'stock', 
    ];
    

    public $timestamps = false; 

    // 🔗 Relasi ke peminjaman
    public function borrowRequests()
    {
        return $this->hasMany(\App\Models\BorrowRequest::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category'); 
    }

}

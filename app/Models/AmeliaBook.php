<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmeliaBook extends Model
{
    protected $table = 'amelia_books';

    // Tambahkan 'image' agar data gambar bisa disimpan
    protected $fillable = ['title', 'author', 'year', 'category_id', 'image','pdf_file', 'description'];

    public function category()
    {
        return $this->belongsTo(AmeliaCategory::class, 'category_id');
    }

    public function borrowings()
    {
        return $this->hasMany(AmeliaBorrowing::class, 'book_id');
    }
}

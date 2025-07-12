<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmeliaBorrowing extends Model
{
    protected $table = 'amelia_borrowings';

    protected $fillable = [
    'member_id',
    'book_id',
    'borrowed_at',
    'returned_at',
     'status', // ← tambahkan ini
];

    public function book()
    {
        return $this->belongsTo(AmeliaBook::class, 'book_id');
    }

    public function member()
    {
        return $this->belongsTo(AmeliaMember::class, 'member_id');
    }
    public function borrowings()
{
    return $this->hasMany(AmeliaBorrowing::class, 'member_id');
}
}

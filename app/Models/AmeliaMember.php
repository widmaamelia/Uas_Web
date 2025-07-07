<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AmeliaMember extends Model
{
    protected $table = 'amelia_members';

    protected $fillable = ['user_id', 'name', 'nim', 'email', 'jurusan'];

    public function borrowings()
    {
        return $this->hasMany(AmeliaBorrowing::class, 'member_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

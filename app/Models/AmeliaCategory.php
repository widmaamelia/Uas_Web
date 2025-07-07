<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmeliaCategory extends Model
{
     protected $table = 'amelia_categories';

    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(AmeliaBook::class, 'category_id');
    }
}

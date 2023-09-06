<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmCategory extends Model
{
    protected $table = 'film_category';
    public function film()
    {
        return $this->hasOne(Film::class, 'film_id');
    }

    public function category()
    {
        return $this->hasMany(Category::class, 'category_id');
    }
}

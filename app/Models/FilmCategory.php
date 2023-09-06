<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmCategory extends Model
{
    protected $table = 'film_category';
    public function getFilm()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }

    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

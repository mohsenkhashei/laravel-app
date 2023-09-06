<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'film';

    protected $primaryKey = 'film_id';

    public function language()
    {
        return $this->belongsTo(Language::class,'language_id');
    }

    public function actors()
    {
        return $this->hasMany(FilmActors::class, 'actor_id');
    }

    public function category()
    {
        return $this->belongsTo(FilmCategory::class, 'category_id');
    }
}

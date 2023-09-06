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
        return $this->hasMany(FilmActors::class, 'film_id');
    }

    public function categories()
    {
        return $this->hasOne(FilmCategory::class, 'film_id');
    }

    public function text()
    {
        return $this->belongsTo(FilmText::class, 'film_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'film_id');
    }
}

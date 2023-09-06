<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmActors extends Model
{
    protected $table = 'film_actor';
    public function getFilm()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }

    public function getActor()
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }




}

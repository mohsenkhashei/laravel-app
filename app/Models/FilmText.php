<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmText extends Model
{
    protected $table = 'film_text';
    protected $primaryKey = 'film_id';

    public function getText()
    {
        return $this->hasOne(Film::class);
    }
}

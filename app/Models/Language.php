<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
   protected $table = 'language';
   protected $primaryKey = 'language_id';
   public function film() {
       return $this->hasMany(Film::class);
   }
}

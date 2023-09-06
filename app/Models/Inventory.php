<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
   protected $table = 'inventory';
   protected $primaryKey = 'inventory_id';

   public function film()
   {
       return $this->belongsTo(Film::class, 'film_id');
   }

   public function store()
   {
       return $this->belongsTo(Store::class, 'store_id');
   }
}

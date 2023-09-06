<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';
    protected $primaryKey = 'store_id';

    public function getStaff()
    {
        return $this->hasOne(Staff::class, 'staff_id');
    }
}

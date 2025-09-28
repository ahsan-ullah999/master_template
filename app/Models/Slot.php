<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = ['name','start_time','end_time','order_cutoff_time','sort_order','status'];

    public function routines()
    {
        return $this->hasMany(Routine::class);
    }
}

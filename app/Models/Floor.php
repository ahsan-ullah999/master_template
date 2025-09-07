<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = ['building_id','name','number','status'];

    public function building() {
        return $this->belongsTo(Building::class);
    }

    public function flats() {
        return $this->hasMany(Flat::class);
    }
}

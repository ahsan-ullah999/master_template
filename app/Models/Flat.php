<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    protected $fillable = ['floor_id','name','flat_number','status'];

    public function floor() {
        return $this->belongsTo(Floor::class);
    }

    public function rooms() {
        return $this->hasMany(Room::class);
    }
}

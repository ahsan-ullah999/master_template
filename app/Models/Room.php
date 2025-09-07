<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['flat_id','name','room_number','status'];

    public function flat() {
        return $this->belongsTo(Flat::class);
    }

    public function seats() {
        return $this->hasMany(Seat::class);
    }
}

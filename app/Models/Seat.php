<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['room_id','seat_number','status'];

    public function room() {
        return $this->belongsTo(Room::class);
    }

}

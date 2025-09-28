<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['room_id','seat_number','description','status'];

    public function room() {
        return $this->belongsTo(Room::class);
    }
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_seat')->withTimestamps();
    }

}

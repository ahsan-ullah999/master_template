<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = ['branch_id','name','address','status'];

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function floors() {
        return $this->hasMany(Floor::class);
    }
}

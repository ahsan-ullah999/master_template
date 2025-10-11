<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'company_id','branch_id','building_id','floor_id','flat_id','room_id',
        'title','details','priority'
    ];

    public function company()  { return $this->belongsTo(Company::class); }
    public function branch()   { return $this->belongsTo(Branch::class); }
    public function building() { return $this->belongsTo(Building::class); }
    public function floor()    { return $this->belongsTo(Floor::class); }
    public function flat()     { return $this->belongsTo(Flat::class); }
    public function room()     { return $this->belongsTo(Room::class); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
        protected $fillable = [
        'user_id','company_id','branch_id','building_id','floor_id','flat_id','room_id','seat_id',
        'rental_id',
        'admission_date','effective_date',
        'photo','name','phone','email','date_of_birth','national_id',
        'father_name','father_contact','mother_name',
        'blood_group','permanent_address',
        'local_guardian_name','local_guardian_relation','local_guardian_contact',
        'status',
    ];


    /** Relationships */
    public function user()     { return $this->belongsTo(User::class); }
    public function company()  { return $this->belongsTo(Company::class); }
    public function branch()   { return $this->belongsTo(Branch::class); }
    public function building() { return $this->belongsTo(Building::class); }
    public function floor()    { return $this->belongsTo(Floor::class); }
    public function flat()     { return $this->belongsTo(Flat::class); }
    public function room()     { return $this->belongsTo(Room::class); }
    public function seat()     { return $this->belongsTo(Seat::class); }

    /** Scopes */
    public function scopeActive($q)    { $q->where('status', 'active'); }
    public function scopeSuspended($q) { $q->where('status', 'suspended'); }

    // Member.php
    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'member_seat'); 
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
        protected $fillable = [
        'company_id',
        'name',
        'branch_id',
        'email',
        'mobile_number',
        'alternate_contact_number',
        'website',
        'country',
        'district',
        'upazila',
        'zip_code',
        'landmark',
        'status',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}

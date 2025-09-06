<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'business_code',
        'start_date',
        'financial_year_start_month',
        'date_format',
        'currency_precision',
        'quantity_precision',
        'currency',
        'logo',
        'website',
        'contact_number',
        'alternate_contact_number',
        'country',
        'district',
        'upazila',
        'branch',
        'zip_code',
        'landmark',
        'time_zone',
        'off_days',
        'leave_approval_structure',
        'attendance_approval',
        'probation_period',
        'service_age',
        'address',
        'status',
    ];
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

}

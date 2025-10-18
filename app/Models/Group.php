<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'address',
        'logo',
        'login_background',
    ];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['code','name','alt_name','description','price','image','status'];

    public function routines()
    {
        return $this->hasMany(Routine::class, 'product_id');
    }
}

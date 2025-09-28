<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutineItem extends Model
{
    protected $fillable = [
        'routine_id',
        'product_id',
        'alternative_product_id',
        'position',
        'is_optional',
    ];

    public function routine()
    {
        return $this->belongsTo(Routine::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function alternative()
    {
        return $this->belongsTo(Product::class, 'alternative_product_id');
    }
}

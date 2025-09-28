<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $fillable = [
        'member_id',
        'slot_id',
        'routine_id',
        'order_date',
        'total',           // subtotal (sum of items)
        'discount_amount', // computed discount applied
        'grand_total',   // total after discount
        'status',
        'created_by',
        'delivered_by',
        'delivered_at'
    ];

    public function items()
    {
        return $this->hasMany(ProductOrderItem::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderItem extends Model
{
    protected $fillable = ['product_order_id','product_id','qty','price','total'];

    public function product() { return $this->belongsTo(Product::class); }
    public function order() { return $this->belongsTo(ProductOrder::class,'product_order_id'); }
}

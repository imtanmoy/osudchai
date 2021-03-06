<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'name',
        'unit_price',
        'discount_amount',
        'quantity',
        'product_id',
        'order_id',
        'product_option_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class, 'product_option_id', 'id');
    }
}

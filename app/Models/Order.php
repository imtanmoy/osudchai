<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_no',
        'ordered_on',
        'shipped_on',
        'total_amount',
        'sub_total',
        'discount_amount',
        'shipping_cost',
        'tax',
        'shipping_status',
        'customer_comment',
        'address_id',
        'user_id',
        'payment_method_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }

    public function statuses()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_has_order_statuses', 'order_id', 'order_status_id')->withPivot('comment')->withTimestamps();
    }
}

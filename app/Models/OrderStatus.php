<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color',
    ];

    protected $dates = ['created_at', 'updated_at'];


    protected $hidden = [];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_has_order_statuses', 'order_id', 'order_status_id')->withPivot('comment')->withTimestamps();
    }
}

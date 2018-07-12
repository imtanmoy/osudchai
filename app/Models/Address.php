<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed address2
 */
class Address extends Model
{
    protected $fillable = ['address1', 'address2', 'post_code', 'user_id', 'city_id', 'area_id'];

    protected $hidden = ['user_id', 'city_id', 'area_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

//    public function orders()
//    {
//        return $this->hasMany(Order::class, 'address_id', 'id');
//    }

    public function getFullAddressAttribute()
    {
        return "{$this->address1},{$this->address2}, Area: {$this->area->name}, City: {$this->city->name}";
    }
}

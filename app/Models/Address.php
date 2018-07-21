<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

/**
 * @property mixed address2
 * @property mixed address1
 * @property mixed post_code
 * @property mixed city
 * @property mixed user_id
 */
class Address extends Model
{
    use Eloquence;

    protected $fillable = ['address1', 'address2', 'post_code', 'user_id', 'city_id', 'area_id'];

    protected $hidden = ['user_id', 'city_id', 'area_id', 'created_at', 'updated_at'];

    protected $dates = ['created_at', 'deleted_at'];

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

    public function orders()
    {
        return $this->hasMany(Order::class, 'address_id', 'id');
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address1},{$this->address2}, Area: {$this->area->name}, City: {$this->city->name}";
    }
}

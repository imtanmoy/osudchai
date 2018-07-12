<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}

<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_customer_group', 'customer_group_id', 'user_id');
    }
}

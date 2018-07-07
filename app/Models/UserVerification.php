<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    protected $fillable = ['token', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

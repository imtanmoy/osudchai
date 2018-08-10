<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed user_id
 * @property mixed user
 * @property mixed src
 */
class Prescription extends Model
{
    protected $fillable = ['title', 'src', 'provider', 'user_id'];

    protected $hidden = ['created_at', 'updated_at', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

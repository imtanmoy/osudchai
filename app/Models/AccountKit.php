<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed access_token
 */
class AccountKit extends Model
{
    protected $fillable = [
        'account_kit_user_id',
        'access_token',
        'token_refresh_interval_sec',
        'number',
        'country_prefix',
        'national_number'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

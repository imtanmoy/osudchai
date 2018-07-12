<?php

namespace App;

use App\Models\Address;
use App\Models\CustomerGroup;
use App\Models\Prescription;
use App\Models\SocialAccount;
use App\Models\UserVerification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'is_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_verified'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function verification()
    {
        return $this->hasOne(UserVerification::class, 'user_id', 'id');
    }

    public function accounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customerGroup()
    {
        return $this->belongsToMany(CustomerGroup::class, 'user_customer_group', 'user_id', 'customer_group_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'user_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Strength extends Model
{
//    use Cachable;

    protected $fillable = ['value'];
    protected $hidden = ['created_at', 'updated_at'];


    public function products()
    {
        return $this->hasMany(Product::class, 'strength_id', 'id');
    }
}

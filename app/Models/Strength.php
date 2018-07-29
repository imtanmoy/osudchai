<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Strength extends Model
{
//    use Cachable;
    use Eloquence;

    protected $fillable = ['value'];
    protected $hidden = ['created_at', 'updated_at'];


    public function products()
    {
        return $this->hasMany(Product::class, 'strength_id', 'id');
    }
}

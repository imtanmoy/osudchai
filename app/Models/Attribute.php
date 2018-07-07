<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
//    use Cachable;

    protected $fillable = ['name'];

    public function values()
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_id', 'id');
    }
}

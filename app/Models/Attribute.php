<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

/**
 * @property mixed name
 */
class Attribute extends Model
{
//    use Cachable;
    use Eloquence;

    protected $fillable = ['name'];

    public function values()
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_id', 'id');
    }
}

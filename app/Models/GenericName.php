<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class GenericName extends Model
{
//    use Cachable;
    use Eloquence;

    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class, 'generic_name_id', 'id');
    }
}

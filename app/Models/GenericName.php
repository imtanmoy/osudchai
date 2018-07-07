<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class GenericName extends Model
{
    use Cachable;

    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

//    public function products()
//    {
//        return $this->belongsToMany(Product::class, 'product_generic_names', 'generic_name_id', 'product_id');
//    }
}

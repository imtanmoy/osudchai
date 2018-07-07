<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['attribute_id', 'value', 'product_id'];

    public function attribute_name()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

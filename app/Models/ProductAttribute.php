<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['attribute_id', 'value', 'product_id'];

    protected $hidden = ['created_at', 'updated_at', 'attribute_id', 'product_id', 'attribute_name'];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return "{$this->attribute_name->name}";
    }

    public function attribute_name()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

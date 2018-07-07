<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $fillable = ['name', 'path', 'thumbnail_path', 'featured', 'provider', 'product_id'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'featured', 'product_id'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

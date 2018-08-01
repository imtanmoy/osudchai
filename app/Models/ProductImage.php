<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    protected $fillable = ['name', 'src', 'cover', 'provider', 'product_id'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'featured', 'product_id'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

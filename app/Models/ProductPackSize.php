<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPackSize extends Model
{
    protected $fillable = [
        'quantity',
        'price'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function packSizeValues()
    {
        return $this->belongsToMany(PackSizeValue::class, 'packsize_value_product_packsize');
    }
}

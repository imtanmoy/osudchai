<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = [
        'quantity',
        'price',
        'stock_status'
    ];

    protected $hidden = ['product_id', 'option_id', 'option_value_id', 'created_at', 'updated_at'];

    protected $with = ['option', 'optionValue'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class, 'option_value_id', 'id');
    }

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

}

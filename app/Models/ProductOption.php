<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = [
        'quantity',
        'price'
    ];

    protected $hidden = ['product_id', 'created_at', 'updated_at'];

    protected $appends = ['option_value'];

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
    public function optionValues()
    {
        return $this->belongsToMany(OptionValue::class, 'option_value_product_option', 'product_option_id', 'option_value_id', 'id', 'id');
    }

    function getOptionValueAttribute()
    {
        return $this->optionValues()->first();
    }
}

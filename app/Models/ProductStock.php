<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductStock extends Model
{
    use LogsActivity;

    protected $fillable = ['product_id', 'available_qty', 'minimum_order_qty', 'stock_status', 'subtract_stock'];

    protected $hidden = ['product_id', 'subtract_stock', 'created_at', 'updated_at'];

    protected static $logAttributes = ['product_id', 'available_qty', 'minimum_order_qty', 'stock_status', 'subtract_stock'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property mixed id
 */
class ProductType extends Model
{
    use LogsActivity;
//    use Cachable;
    use Eloquence;


    protected $fillable = [
        'name'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    protected static $logAttributes = ['name'];


    public function products()
    {
        return $this->hasMany(Product::class, 'product_type_id', 'id');
    }
}

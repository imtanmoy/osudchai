<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Spatie\Activitylog\Traits\LogsActivity;

class Manufacturer extends Model
{
    use LogsActivity;
//    use Cachable;
    use Eloquence;

    protected $table = 'manufacturers';

    protected $fillable = [
        'name', 'phone', 'email', 'address',
    ];

    protected $hidden = ['phone', 'email', 'address', 'created_at', 'updated_at'];

    protected static $logAttributes = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'manufacturer_id', 'id');
    }
}

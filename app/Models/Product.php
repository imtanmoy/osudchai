<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use LogsActivity;
//    use Cachable;
    use SearchableTrait;
    use HasSlug;


    protected $fillable = [
        'name',
        'sku',
        'description',
        'is_active',
        'price',
        'manufacturer_id',
        'category_id',
        'product_type_id',
        'strength_id',
        'generic_name_id',
    ];

    protected $hidden = [
        'deleted_at',
        'category_id',
        'manufacturer_id',
        'product_type_id',
        'strength_id',
        'generic_name_id',
        'created_at',
        'updated_at',
    ];

    protected static $logAttributes = [
        'name',
        'sku',
        'description',
        'manufacturer_id',
        'category_id',
        'product_type_id',
        'is_active',
        'price',
        'strength_id',
        'generic_name_id',
    ];


    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function product_type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function generic_name()
    {
        return $this->belongsTo(GenericName::class, 'generic_name_id', 'id');
    }
    public function strength()
    {
        return $this->belongsTo(Strength::class, 'strength_id', 'id');
    }

    public function stock()
    {
        return $this->hasOne(ProductStock::class, 'product_id', 'id');
    }
}

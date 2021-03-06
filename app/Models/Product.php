<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property null product_type_id
 * @property null generic_name_id
 * @property mixed manufacturer_id
 * @property mixed is_active
 * @property mixed description
 * @property mixed slug
 * @property mixed sku
 * @property mixed name
 * @property mixed id
 * @property mixed manufacturer
 * @property int prescription_required
 */
class Product extends Model
{
    use LogsActivity;
//    use Cachable;
    use SearchableTrait;
    use HasSlug;


    protected $fillable = [
        'name',
        'sku',
        'slug',
        'description',
        'is_active',
        'prescription_required',
        'price',
        'manufacturer_id',
        'category_id',
        'product_type_id',
        'strength_id',
        'generic_name_id',
    ];

    protected $hidden = [
        'deleted_at',
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
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'products.name' => 10,
            'products.description' => 8,
            'generic_names.name' => 7,
            'categories.name' => 6,
            'manufacturers.name' => 4
        ],
        'joins' => [
            'categories' => ['categories.id', 'products.category_id'],
            'manufacturers' => ['manufacturers.id', 'products.manufacturer_id'],
            'generic_names' => ['generic_names.id', 'products.generic_name_id'],
        ],
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

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }

    public function cover()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'id')->where('cover', '=', 1);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id')->where('cover', '!=', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(ProductOption::class, 'product_id', 'id');
    }

    /**
     * @param string $term
     * @return Collection
     */
    public function searchProduct(string $term): Collection
    {
        return self::search($term)->where('is_active', 1)->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
//    use Cachable;
    use NodeTrait;
    use LogsActivity;


    protected $fillable = ['name', 'order', 'is_active'];

    protected $hidden = ['created_at', 'updated_at', 'is_active', '_lft', '_rgt'];

    protected static $logAttributes = ['name', 'order', 'parent_id'];

    public function isActive()
    {
        if ($this->{'is_active'} == 0) {
            return false;
        } else {
            return true;
        }
    }


    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }


//    public function products()
//    {
//        return $this->hasMany(Product::class, 'category_id', 'id');
//    }


    /**
     * Delete all sub categories when Main (Parent) category is deleted.
     */
    public static function boot()
    {
        // Reference the parent::boot() class.
        parent::boot();
        // Delete the parent and all of its children on delete.
        //static::deleted(function($category) {
        //    $category->parent()->delete();
        //    $category->children()->delete();
        //});
        Category::deleting(function ($category) {
            foreach ($category->children as $subcategory) {
                $subcategory->delete();
            }
        });
    }
}

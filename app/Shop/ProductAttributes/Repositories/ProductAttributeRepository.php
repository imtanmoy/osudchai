<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 8/2/2018
 * Time: 1:00 PM
 */

namespace App\Shop\ProductAttributes\Repositories;


use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Shop\Base\BaseRepository;

class ProductAttributeRepository extends BaseRepository implements ProductAttributeRepositoryInterface
{

    protected $model;

    /**
     * ProductAttributeRepository constructor.
     * @param ProductAttribute $productAttribute
     */
    public function __construct(ProductAttribute $productAttribute)
    {
        parent::__construct($productAttribute);
        $this->model = $productAttribute;
    }


    public function createProductAttribute(Product $product, Attribute $attribute, array $data)
    {
        $productAttribute = new ProductAttribute($data);
        $productAttribute->attribute_name()->associate($attribute);
        $product->attributes()->save($productAttribute);
        return $productAttribute;
    }
}

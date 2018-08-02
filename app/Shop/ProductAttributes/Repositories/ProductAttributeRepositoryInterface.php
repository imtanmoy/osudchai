<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 8/2/2018
 * Time: 12:58 PM
 */

namespace App\Shop\ProductAttributes\Repositories;


use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;

interface ProductAttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function createProductAttribute(Product $product, Attribute $attribute, array $data);
}

<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/1/18
 * Time: 1:17 PM
 */

namespace App\Shop\Products\Transformations;


use App\Models\Product;

trait ProductTransformable
{
    /**
     * Transform the product
     *
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $prod = new Product;
        $prod->id = (int)$product->id;
        $prod->name = $product->name;
        $prod->sku = $product->sku;
        $prod->slug = $product->slug;
        $prod->description = $product->description;
//        $prod->cover = asset("storage/$product->cover");
        $prod->quantity = $product->stock->quantity;
        $prod->price = $product->stock->price;
        $prod->is_active = $product->is_active;
        $prod->manufacturer_id = (int)$product->manufacturer_id;
        return $prod;
    }
}
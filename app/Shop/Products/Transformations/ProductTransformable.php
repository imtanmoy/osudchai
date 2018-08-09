<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/1/18
 * Time: 1:17 PM
 */

namespace App\Shop\Products\Transformations;


use App\Models\Product;
use Storage;

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
        $prod->category = $product->category()->exists() ? $product->category : null;
        $prod->quantity = $product->stock()->exists() ? $product->stock->available_qty : 0;
        $prod->price = $product->stock()->exists() ? $product->stock->price : 0;
        $prod->manufacturer = $product->manufacturer()->exists() ? $product->manufacturer : null;
        $prod->generic_name = $product->generic_name()->exists() ? $product->generic_name : null;
        $prod->strength = $product->strength()->exists() ? $product->strength : null;
        $prod->product_type = $product->product_type()->exists() ? $product->product_type : null;
        $prod->attributes = $product->attributes()->exists() ? $product->attributes : [];
        $prod->options = $product->options()->exists() ? $product->options : [];
        $prod->cover = $this->transformCover($product->cover);
        $prod->images = $this->transformImages($product->images);
        $prod->is_active = $product->is_active;
//        $prod->images = $product->images;
        return $prod;
    }


    private function transformImages($images)
    {
        $images = collect($images)->map(function ($image) {
            return Storage::disk('public')->url($image->src);
//            return asset('storage/' . $image->src);
        });
        return $images;
    }

    private function transformCover($image)
    {
        if ($image != null) {
            return Storage::disk('public')->url($image->src);
        }
        return 'http://via.placeholder.com/350x150';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 1/14/2018
 * Time: 5:21 PM
 */

namespace App\Repositories\Product;


use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\GenericName;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImages;
use App\Models\ProductOption;
use App\Models\ProductStock;
use App\Models\ProductType;
use App\Models\Strength;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use Carbon\Carbon;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Request;
use Storage;

class ProductRepository implements ProductInterface
{
    protected $product;
    protected $strength;
    protected $product_type;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    function getAll()
    {
        return $this->product->all();
    }

    /**
     * @param $id
     * @return Product
     * @throws ProductNotFoundException
     */
    function getById($id): Product
    {
        try {
            $product = $this->product->find($id);
            return $product;
        } catch (ModelNotFoundException $exception) {
            throw new ProductNotFoundException($exception);
        }

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Http\JsonResponse
     */
    function create(array $attributes)
    {

        try {
            if (!empty($attributes)) {

                $product = $this->product->create($attributes);

                if (isset($attributes['generic_name'])) {
                    $genericName = GenericName::firstOrCreate(['name' => $attributes['generic_name']]);
                    if (!empty($genericName->id)) {
                        $product->generic_name()->associate($genericName);
                        $product->save();
                    }
                }

                if (isset($attributes['strength'])) {
                    $strength = Strength::firstOrCreate(['value' => $attributes['strength']]);
                    if (!empty($strength->id)) {
                        $product->strength()->associate($strength);
                        $product->save();
                    }
                }

                if (isset($attributes['available_qty'])) {
                    $available_qty = $attributes['available_qty'] ?: 1;
                    $minimum_order_qty = $attributes['minimum_order_qty'] ?: 1;
                    $stock_status = $attributes['stock_status'] ?: 'inStock';

                    if (isset($attributes['subtract_stock']) && $attributes['subtract_stock'] != null) {
                        $attributes['subtract_stock'] = 1;
                    } else {
                        $attributes['subtract_stock'] = 0;
                    }
                    $subtract_stock = $attributes['subtract_stock'] ?: 0;

                    if (!empty($available_qty)) {
                        $product_stock = new ProductStock(['available_qty' => $available_qty, 'minimum_order_qty' => $minimum_order_qty, 'stock_status' => $stock_status, 'subtract_stock' => $subtract_stock]);
                        $product->stock()->save($product_stock);
                    }
                }

                if (isset($attributes['attribute_name']) && isset($attributes['attribute_value'])) {

                    $values = $attributes['attribute_value'];
                    $names = $attributes['attribute_name'];
                    foreach ($names as $name) {
                        if (!empty($name)) {
                            $key = array_search($name, $names);
                            $attribute = Attribute::firstOrCreate(['name' => $name]);
                            $product_attribute = new ProductAttribute(['value' => $values[$key], 'attribute_id' => $attribute->id]);
                            $product->attributes()->save($product_attribute);
                        }
                    }
                }

                if (isset($attributes['featuredImg'])) {
                    $featuredImage = $attributes['featuredImg'];
                    $fileName = trim(time() . $featuredImage->getClientOriginalName());
                    Storage::disk('public')->put($fileName, File::get($featuredImage));
                    $url = Storage::disk('public')->url($fileName);
                    ProductImages::create(['name' => $fileName, 'path' => $url, 'featured' => 1, 'product_id' => $product->id]);
                }

                if (!empty($attributes['images'])) {
                    $images = $attributes['images'];
                    foreach ($images as $img) {
                        $imgName = trim(time() . $img->getClientOriginalName());
                        Storage::disk('public')->put($imgName, File::get($img));
                        $iurl = Storage::disk('public')->url($imgName);
                        ProductImages::create(['name' => $imgName, 'path' => $iurl, 'featured' => 0, 'product_id' => $product->id]);
                    }
                }


                return response()->json(['message' => 'Product Created'], 200);
            } else {
                return response()->json(['message' => 'Could not get the data'], 400);
            }
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 500);
        }


//        return $this->product->create($attributes);
    }

    function update($id, array $attributes)
    {
        try {
            $product = Product::findOrFail($id);
            $product->name = $attributes['name'];
            $product->sku = $attributes['sku'];
            $product->description = $attributes['description'];
            $product->manufacturer_id = $attributes['manufacturer_id'];
            $product->category_id = $attributes['category_id'];
            $product->product_type_id = $attributes['product_type_id'];
            $product->price = $attributes['price'];

            if (isset($attributes['generic_name']) && !empty($attributes['generic_name'])) {
                $genericName = GenericName::firstOrCreate(['name' => $attributes['generic_name']]);
                if (!empty($genericName->id) && $product->generic_name_id != $genericName->id) {
                    $product->generic_name()->dissociate();
                    $product->generic_name()->associate($genericName);
                    $product->save();
                }
            }

            if (isset($attributes['strength']) && !empty($attributes['strength'])) {
                $strength = Strength::firstOrCreate(['value' => $attributes['strength']]);
                if (!empty($strength->id) && $product->strength_id != $strength->id) {
                    $product->strength()->dissociate();
                    $product->strength()->associate($strength);
                    $product->save();
                }
            }

            if (isset($attributes['available_qty'])) {
                $available_qty = $attributes['available_qty'] ?: 1;
                $minimum_order_qty = $attributes['minimum_order_qty'] ?: 1;
                $stock_status = $attributes['stock_status'] ?: 'inStock';

                if (isset($attributes['subtract_stock']) && $attributes['subtract_stock'] != null) {
                    $attributes['subtract_stock'] = 1;
                } else {
                    $attributes['subtract_stock'] = 0;
                }
                $subtract_stock = $attributes['subtract_stock'] ?: 0;

                $product->stock()->update([
                    'available_qty' => $available_qty,
                    'minimum_order_qty' => $minimum_order_qty,
                    'stock_status' => $stock_status,
                    'subtract_stock' => $subtract_stock,
                ]);
            }

            if (isset($attributes['attribute_name']) && isset($attributes['attribute_value'])) {

                $values = $attributes['attribute_value'];
                $names = $attributes['attribute_name'];
                foreach ($names as $name) {
                    if (!empty($name)) {
                        $key = array_search($name, $names);
                        $attribute = Attribute::firstOrCreate(['name' => $name]);
                        $product_attribute = new ProductAttribute(['value' => $values[$key], 'attribute_id' => $attribute->id]);
                        $product->attributes()->save($product_attribute);
                    }
                }
            }


            $success = $product->save();


            return response()->json(['message' => 'Product Updated'], 200);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Associate the product attribute to the product
     *
     * @param ProductOption $productOption
     * @return ProductOption
     */
    public function saveProductOption(ProductOption $productOption): ProductOption
    {
        $this->product->options()->save($productOption);
        return $productOption;
    }

    /**
     * @param ProductOption $productOption
     * @param Option $option
     * @param OptionValue $optionValue
     * @return bool
     */
    public function saveCombination(ProductOption $productOption, Option $option, OptionValue $optionValue)
    {
        return $productOption->option()->save($option) && $productOption->optionValue()->save($optionValue);
    }
}

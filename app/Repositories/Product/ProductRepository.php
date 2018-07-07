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
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImages;
use App\Models\ProductStock;
use App\Models\ProductType;
use App\Models\Strength;
use Carbon\Carbon;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
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

    function getById($id)
    {
        try {
            $product = $this->product->find($id);

            $product->load('product_type');
            $product->load('manufacturer');
            $product->load('featuredPhoto');
            $product->load('images');
//            $product->load('subCategory');
            $product->load('category');


//            $category = $product->subCategory->parent;

//            $product['category'] = $category;


//            if ($product->subCategory->name == "Medicine" && $product->category->name == "Pharmacy") {
            $strength = DB::select('SELECT strengths.strength FROM strengths LEFT JOIN product_strengths ON product_strengths.strength_id = strengths.id WHERE product_strengths.product_id = ' . $id . ' LIMIT 1');
            $product['strength'] = $strength[0]->strength;

            $generic_name = DB::select('SELECT generic_names.id, generic_names.name FROM generic_names LEFT JOIN product_generic_names ON product_generic_names.generic_name_id = generic_names.id WHERE product_generic_names.product_id = ' . $id . ' LIMIT 1');
            $product['generic_name'] = $generic_name[0];
//            }

            return $product;

//            return response()->json($product, 200);
        } catch (\Exception $exception) {
//            return response()->json(['message' => $exception->getMessage()], 400);
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

//            return response()->json([$product->name, $attributes['name']]);
            $product->name = $attributes['name'];
            $product->sku = $attributes['sku'];
            $product->description = $attributes['description'];
            $product->manufacturer_id = $attributes['manufacturer_id'];
            $product->category_id = $attributes['category_id'];
            $product->product_type_id = $attributes['product_type_id'];


//            return response()->json([$product, $attributes]);

            $success = $product->save();

//            return response()->json([$product, $attributes, $success]);


            if (isset($attributes['strength'])) {

                $strength = Strength::firstOrCreate(['strength' => $attributes['strength']]);

                if (!empty($strength->id)) {
                    DB::table('product_strengths')->where('product_id', $product->id)->update(['strength_id' => $strength->id]);
                }
            }

            if (isset($attributes['generic_name'])) {

                $genericName = GenericName::firstOrCreate(['name' => $attributes['generic_name']]);

                if (!empty($genericName->id)) {
                    DB::table('product_generic_names')->where('product_id', $product->id)->update(['generic_name_id' => $genericName->id]);
                }
            }

//            if (isset($attributes['available_qty'])) {
//
//            }
//
//            if (isset($attributes['stock_status'])) {
//
//            }
//
//            if (isset($attributes['minimum_order_qty'])) {
//
//            }

//            if (isset($attributes['price'])) {
//                $price = $attributes['price'];
//                if (!empty($price)) {
//                    $current = Carbon::now();
//                    $future = $current->addMonth(1);
//                    $product_price = ['base_price' => $price, 'is_active' => 1, 'exp_date' => $future->toDateTimeString()];
//                    $product->price()->update($product_price);
//                }
//            }

            return response()->json(['message' => 'Product Updated'], 200);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
    }
}

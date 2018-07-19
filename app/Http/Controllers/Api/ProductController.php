<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->where('is_active', '=', 1);
        $products->load([
            'product_type',
            'manufacturer',
            'category',
            'generic_name',
            'strength',
            'attributes',
            'featuredPhoto',
            'images',
            'stock',
            'options'
        ]);
        return response()->json($products);
    }

    public function show($id)
    {
        try {
            $product = Product::with([
                'product_type',
                'manufacturer',
                'category',
                'generic_name',
                'strength',
                'attributes',
                'featuredPhoto',
                'images',
                'options',
                'stock'
            ])->findOrFail($id);

//
//            $options = collect($product->options);
//
//            return $options->map(function (ProductOption $productOption) {
//                return $productOption->optionValues()->first();
//            });

            if ($product == null || $product->is_active == 0) {
                return response()->json(['message' => 'Product not found'], 404);
            }
            return response()->json($product);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

    }
}

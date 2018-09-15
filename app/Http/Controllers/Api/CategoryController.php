<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use Cache;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('categories', 22 * 60, function () {
            return Category::get()->toTree();
        });
        return response()->json($categories);
    }

    public function show($id)
    {
//        $categories = Category::with('descendants')->findOrFail($id);
//        $categories = Category::findOrFail($id)->toTree($id);
//        $categories = Category::descendantsOf($id)->toTree($id);
        $category = Category::with('descendants')->findOrFail($id);
        $category['children'] = $category->descendants;
        unset($category['descendants']);
        return response()->json($category);
    }

    public function productsByCategory($id)
    {
        $products = Product::where('category_id', $id)->where('is_active', '=', 1)->get();
        $products->load([
            'product_type',
            'manufacturer',
            'category',
            'generic_name',
            'strength',
            'attributes',
            'cover',
            'images',
            'stock'
        ]);
        return response()->json($products);
    }
}

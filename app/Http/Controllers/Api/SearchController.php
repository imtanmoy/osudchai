<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Shop\Products\Repositories\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    use ProductTransformable;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * SearchController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $list = Product::query()->search($query)->where('is_active', 1);
//        $list = $this->productRepository->searchProduct($query);


        if ($request->has('generic_name')) {
            $generic_name = $request->input('generic_name');
            $list->whereHas('generic_name', function ($query) use ($generic_name) {
                $query->where('name', '=', $generic_name);
            });
        }


        if ($request->has('manufacturer')) {
            $manufacturer = $request->input('manufacturer');
            $list->whereHas('manufacturer', function ($query) use ($manufacturer) {
                $query->where('name', '=', $manufacturer);
            });
        }

        if ($request->has('category')) {
            $category = $request->input('category');
            $list->whereHas('category', function ($query) use ($category) {
                $query->where('name', '=', $category);
            });
        }

        $list = collect($list->get());

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        });
        return response()->json(['total_count' => count($list), 'results' => $products]);
    }
}

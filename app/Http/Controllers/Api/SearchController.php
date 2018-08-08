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

    public function index(Request $request)
    {
        $query = $request->input('query');
        $list = $this->productRepository->searchProduct($query);

        if ($request->has('generic_name')) {
            $generic_name = $request->input('generic_name');
            $list->whereHas('generic_name', function ($q) use ($generic_name) {
                $q->where('generic_names.name', $generic_name);
            });
        }

        if ($request->has('manufacturer')) {
            $manufacturer = $request->input('manufacturer');
        }

        if ($request->has('category')) {
            $category = $request->input('category');
        }

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        });
        return response()->json($products);
    }
}

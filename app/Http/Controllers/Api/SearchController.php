<?php

namespace App\Http\Controllers\Api;

use App\Shop\Products\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
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
        dd($request->all());
    }
}

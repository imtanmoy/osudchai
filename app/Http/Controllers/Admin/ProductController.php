<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductType;
use App\Repositories\Product\ProductInterface;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ProductController extends Controller
{

    private $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $products = $this->product->getAll();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $manufacturers = Manufacturer::all();
        $categories = Category::all();
        $product_types = ProductType::all();
        return view('admin.products.create', compact('manufacturers', 'categories', 'product_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        return $this->product->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $manufacturers = Manufacturer::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $product_types = ProductType::pluck('name', 'id');
        $product = Product::findOrFail($id);

        return view('admin.products.edit', compact('product', 'manufacturers', 'categories', 'product_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showAdjust($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $product = Product::findOrFail($id);

        return view('admin.products.adjust', compact('product'));
    }

    public function updateAdjust(Request $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        try {
            $product = Product::findOrFail($id);

            if (isset($request->price)) {
                $product->price = $request->price;
                $product->save();
            }

            if (isset($request->available_qty)) {
                $product->stock->update([
                    'available_qty' => $request->available_qty,
                ]);
            }

            if (isset($request->stock_status)) {
                $product->stock->update([
                    'stock_status' => $request->stock_status,
                ]);
            }

            $lastActivity = Activity::all()->last();

            flash($lastActivity->description)->success();

            return redirect()->route('admin.products.index');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
}

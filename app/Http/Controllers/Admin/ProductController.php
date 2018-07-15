<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductOption;
use App\Models\ProductType;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;
use App\Shop\Options\Repositories\OptionRepositoryInterface;
use App\Shop\OptionValues\Repositories\OptionValueRepositoryInterface;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Spatie\Activitylog\Models\Activity;
use Validator;

class ProductController extends Controller
{

    private $productRepo;
    private $optionRepo;
    private $optionValueRepo;

    public function __construct(
        ProductInterface $product,
        OptionRepositoryInterface $optionRepository,
        OptionValueRepositoryInterface $optionValueRepository
    )
    {
        $this->productRepo = $product;
        $this->optionRepo = $optionRepository;
        $this->optionValueRepo = $optionValueRepository;
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
        $products = $this->productRepo->getAll();
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
        return $this->productRepo->create($request->all());
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

        $product = $this->productRepo->getById($id);

        $productOptions = $product->options()->get();

        if (request()->has('delete') && request()->has('pa')) {
            $pa = $productOptions->where('id', request()->input('pa'))->first();
            $pa->optionValues()->detach();
            $pa->delete();
            request()->session()->flash('message', 'Delete successful');
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1]);
        }


        $manufacturers = Manufacturer::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $product_types = ProductType::pluck('name', 'id');
        $product = Product::findOrFail($id);

        $options = $this->optionRepo->listOptions();


        return view('admin.products.edit', compact(
            'product',
            'manufacturers',
            'categories',
            'product_types',
            'productOptions',
            'options'
        ));
//        return $productOptions;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(ProductRequest $request, $id)
    {
        return $this->productRepo->update($id, $request->all());
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

//        $product = Product::findOrFail($id);
        $product = $this->productRepo->getById($id);

        return view('admin.products.adjust', compact('product'));
    }

    public function updateAdjust(Request $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        try {
            $product = $this->productRepo->getById($id);

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

    public function deleteAttributes($id, $aid)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        try {
            $product_attribute = ProductAttribute::findOrFail($aid);
            $product_attribute->delete();
            return response()->json(['status' => true, 'message' => 'Attribute Successfully Deleted']);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }


    /**
     * @param Request $request
     * @param Product $product
     * @return boolean
     */
    private function saveProductCombinations(Request $request, Product $product)
    {
        $fields = $request->only('quantity', 'price');

        if ($errors = $this->validateFields($fields)) {
            return redirect()->route('admin.products.options', [$product->id])
                ->withErrors($errors);
        }

        $quantity = $fields['quantity'];
        $price = $fields['price'];


        $optionValueID = $request->option_value_id;
        $productRepo = new ProductRepository($product);
        $productOption = $productRepo->saveProductOption(new ProductOption(compact('quantity', 'price')));
        $optionValue = $this->optionValueRepo->find($optionValueID);
        $productRepo->saveCombination($productOption, $optionValue);
    }

    /**
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    private function validateFields(array $data)
    {
        $validator = Validator::make($data, [
            'quantity' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator;
        }
    }

    public function addProductOption($id)
    {
        $product = $this->productRepo->getById($id);
        $options = $this->optionRepo->listOptions();

        return view('admin.products.create-options', compact('product', 'options'));
    }

    public function storeProductOption(Request $request, $id)
    {

        $product = $this->productRepo->getById($id);
        if ($request->has('option_id') && $request->has('option_value_id')) {
            $this->saveProductCombinations($request, $product);
            $request->session()->flash('message', 'Attribute combination created successful');
            return redirect()->route('admin.products.edit', [$id, 'combination' => 1]);
        }else{
            return 'sdsds';
        }
    }
}

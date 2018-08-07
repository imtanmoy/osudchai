<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductOption;
use App\Models\ProductStock;
use App\Models\ProductType;
use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use App\Shop\Categories\Repositories\CategoryRepositoryInterface;
use App\Shop\GenericNames\Repositories\GenericNameRepositoryInterface;
use App\Shop\Manufacturers\Repositories\ManufacturerRepositoryInterface;
use App\Shop\Options\Repositories\OptionRepositoryInterface;
use App\Shop\OptionValues\Repositories\OptionValueRepositoryInterface;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepositoryInterface;
use App\Shop\Products\Exceptions\ProductUpdateErrorException;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Repositories\ProductRepositoryInterface;
use App\Shop\Products\Requests\UpdateProductRequest;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\ProductTypes\Repositories\ProductTypeRepositoryInterface;
use App\Shop\Strengths\Repositories\StrengthRepositoryInterface;
use App\Shop\Tools\UploadableTrait;
use DataTables;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Spatie\Activitylog\Models\Activity;
use Validator;

class ProductController extends Controller
{
    use ProductTransformable, UploadableTrait;
    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var GenericNameRepositoryInterface
     */
    private $genericNameRepository;
    /**
     * @var StrengthRepositoryInterface
     */
    private $strengthRepository;
    /**
     * @var OptionRepositoryInterface
     */
    private $optionRepository;
    /**
     * @var OptionValueRepositoryInterface
     */
    private $optionValueRepository;
    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;
    /**
     * @var ProductTypeRepositoryInterface
     */
    private $productTypeRepository;
    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $productAttributeRepository;

    /**
     * ProductController constructor.
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param ProductRepositoryInterface $productRepository
     * @param GenericNameRepositoryInterface $genericNameRepository
     * @param StrengthRepositoryInterface $strengthRepository
     * @param OptionRepositoryInterface $optionRepository
     * @param OptionValueRepositoryInterface $optionValueRepository
     * @param AttributeRepositoryInterface $attributeRepository
     * @param ProductTypeRepositoryInterface $productTypeRepository
     * @param ProductAttributeRepositoryInterface $productAttributeRepository
     */
    public function __construct(
        ManufacturerRepositoryInterface $manufacturerRepository,
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        GenericNameRepositoryInterface $genericNameRepository,
        StrengthRepositoryInterface $strengthRepository,
        OptionRepositoryInterface $optionRepository,
        OptionValueRepositoryInterface $optionValueRepository,
        AttributeRepositoryInterface $attributeRepository,
        ProductTypeRepositoryInterface $productTypeRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository
    )
    {
        $this->manufacturerRepository = $manufacturerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->genericNameRepository = $genericNameRepository;
        $this->strengthRepository = $strengthRepository;
        $this->optionRepository = $optionRepository;
        $this->optionValueRepository = $optionValueRepository;
        $this->attributeRepository = $attributeRepository;
        $this->productTypeRepository = $productTypeRepository;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function index()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $list = $this->productRepository->listProducts('id');
        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepository->searchProduct(request()->input('q'));
        }
        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $manufacturers = $this->manufacturerRepository->listManufacturers();
        $categories = $this->categoryRepository->listCategories();
        $product_types = $this->productTypeRepository->listProductTypes();
        return view('admin.products.create', compact('manufacturers', 'categories', 'product_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
//        dd($request->all());
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $data = collect($request->except('_token', '_method'));

        $product = $this->productRepository->createProduct($data->only(['name', 'sku', 'description'])->toArray());


        $productRepo = new ProductRepository($product);

        if ($request->has('manufacturer')) {
            $manufacturer = $this->manufacturerRepository->findManufacturerById($request->input('manufacturer'));
            $productRepo->associateManufacturer($manufacturer);
        }

        if ($request->has('category')) {
            $category = $this->categoryRepository->findCategoryById($request->input('category'));
            $productRepo->associateCategory($category);
        }

        if ($request->has('product_type')) {
            $product_type = $this->productTypeRepository->findProductTypeById($request->input('product_type'));
            $productRepo->associateProductType($product_type);
        }

        if ($request->has('generic_name')) {
            $generic_name = $this->genericNameRepository->findOneBy(['name' => $request->input('generic_name')]);
            if ($generic_name == null) {
                $generic_name = $this->genericNameRepository->createGenericName(['name' => $request->input('generic_name')]);
            }
            $productRepo->associateGenericName($generic_name);
        }

        if ($request->has('strength')) {
            $strength = $this->strengthRepository->findOneBy(['value' => $request->input('strength')]);
            if ($strength == null) {
                $strength = $this->strengthRepository->createStrength(['value' => $request->input('strength')]);
            }
            $productRepo->associateStrength($strength);
        }


        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
            $productRepo->saveCoverImage($request->file('cover'));
        }


        if ($request->hasFile('images')) {
            $productRepo->saveProductImages(collect($request->file('images')));
        }

        if (
            $request->has('available_qty') &&
            $request->has('minimum_order_qty') &&
            $request->has('price') &&
            $request->has('stock_status')
        ) {
            $available_qty = $request->input('available_qty') ?: 1;
            $minimum_order_qty = $request->input('minimum_order_qty') ?: 1;
            $stock_status = $request->input('stock_status') ?: 'inStock';
            $price = $request->input('price') ?: 0.0;

            $subtract_stock = 1;
            if ((!$request->has('subtract_stock') || $request->input('subtract_stock') == null) && $request->input('subtract_stock') != true) {
                $subtract_stock = 0;
            }
            $product_stock = new ProductStock(['price' => $price, 'available_qty' => $available_qty, 'minimum_order_qty' => $minimum_order_qty, 'stock_status' => $stock_status, 'subtract_stock' => $subtract_stock]);
            $productRepo->saveProductStock($product_stock);
        } else {
            $product_stock = new ProductStock(['price' => 0.0, 'available_qty' => 0, 'minimum_order_qty' => 0, 'stock_status' => 'inStock']);
            $productRepo->saveProductStock($product_stock);
        }

        if ($request->has('attribute_name') && $request->has('attribute_value')) {

            $names = $request->input('attribute_name');
            $values = $request->input('attribute_value');

            foreach ($names as $name) {
                if (!empty($name)) {
                    $key = array_search($name, $names);
                    $attribute = $this->attributeRepository->findOneOrCreate(['name' => $name]);
                    $this->productAttributeRepository->createProductAttribute($product, $attribute, ['value' => $values[$key]]);
                }
            }
        }
        return response()->json(['message' => 'Product Created', 'product' => $product], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $product = $this->productRepository->findProductById($id);

        $productOptions = $product->options()->get();

        if (request()->has('delete') && request()->has('pa')) {
            $pa = $productOptions->where('id', request()->input('pa'))->first();
            $pa->optionValue()->dissociate();
            $pa->delete();
            request()->session()->flash('message', 'Delete successful');
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1]);
        }


        $manufacturers = collect($this->manufacturerRepository->listManufacturers())->pluck('name', 'id');
        $categories = collect($this->categoryRepository->listCategories())->pluck('name', 'id');
        $product_types = collect($this->productTypeRepository->listProductTypes())->pluck('name', 'id');

        $options = $this->optionRepository->listOptions();


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
     * @param UpdateProductRequest $request
     * @param  int $id
     * @return Response
     * @throws ProductUpdateErrorException
     * @throws \Exception
     */
    public
    function update(UpdateProductRequest $request, $id)
    {

        $data = collect($request->except('_token', '_method'));

        $product = $this->productRepository->findProductById($id);

        $productRepo = new ProductRepository($product);

        $productRepo->updateProduct($data->only(['name', 'sku', 'description'])->toArray());

        if ($request->has('manufacturer')) {
            $manufacturer = $this->manufacturerRepository->findManufacturerById($request->input('manufacturer'));
            $productRepo->associateManufacturer($manufacturer);
        }

        if ($request->has('category')) {
            $category = $this->categoryRepository->findCategoryById($request->input('category'));
            $productRepo->associateCategory($category);
        }

        if ($request->has('product_type')) {
            $product_type = $this->productTypeRepository->findProductTypeById($request->input('product_type'));
            $productRepo->associateProductType($product_type);
        }

        if ($request->has('generic_name')) {
            $generic_name = $this->genericNameRepository->findOneBy(['name' => $request->input('generic_name')]);
            if ($generic_name == null) {
                $generic_name = $this->genericNameRepository->createGenericName(['name' => $request->input('generic_name')]);
            }
            $productRepo->associateGenericName($generic_name);
        }

        if ($request->has('strength')) {
            $strength = $this->strengthRepository->findOneBy(['value' => $request->input('strength')]);
            if ($strength == null) {
                $strength = $this->strengthRepository->createStrength(['value' => $request->input('strength')]);
            }
            $productRepo->associateStrength($strength);
        }

        if (
            $request->has('available_qty') &&
            $request->has('minimum_order_qty') &&
            $request->has('price') &&
            $request->has('stock_status')
        ) {
            $available_qty = $request->input('available_qty') ?: 1;
            $minimum_order_qty = $request->input('minimum_order_qty') ?: 1;
            $stock_status = $request->input('stock_status') ?: 'inStock';
            $price = $request->input('price') ?: 0.0;

            $subtract_stock = 1;
            if ((!$request->has('subtract_stock') || $request->input('subtract_stock') == null) && $request->input('subtract_stock') != true) {
                $subtract_stock = 0;
            }
            $productRepo->updateProductStock(['price' => $price, 'available_qty' => $available_qty, 'minimum_order_qty' => $minimum_order_qty, 'stock_status' => $stock_status, 'subtract_stock' => $subtract_stock]);
        }

        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
//            if ($product->images()->where('cover', '=', 1)->exists()) {
            $productRepo->deleteCoverImage();
//            }
            $productRepo->saveCoverImage($request->file('cover'));
        }


        if ($request->hasFile('images')) {
            $productRepo->saveProductImages(collect($request->file('images')));
        }

        if ($request->has('attribute_name') && $request->has('attribute_value')) {

            $names = $request->input('attribute_name');
            $values = $request->input('attribute_value');

            foreach ($names as $name) {
                if (!empty($name)) {
                    $key = array_search($name, $names);
                    $attribute = $this->attributeRepository->findOneOrCreate(['name' => $name]);
                    $this->productAttributeRepository->createProductAttribute($product, $attribute, ['value' => $values[$key]]);
                }
            }
        }

        return response()->json(['message' => 'Product Updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

    public
    function deleteAttributes($id, $aid)
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
    private
    function saveProductCombinations(Request $request, Product $product)
    {
        $fields = $request->only('quantity', 'price', 'stock_status');

        if ($errors = $this->validateFields($fields)) {
            return redirect()->route('admin.products.options', [$product->id])
                ->withErrors($errors);
        }

        $quantity = $fields['quantity'];
        $price = $fields['price'];
        $stock_status = $fields['stock_status'];


        $option = $this->optionRepository->findOptionById($request->option_id);
        $optionValue = $this->optionValueRepository->find($request->option_value_id);


        $productRepo = new ProductRepository($product);

        $productOption = new ProductOption(compact('quantity', 'price', 'stock_status'));

        $productOption->option()->associate($option);
        $productOption->optionValue()->associate($optionValue);


        $productRepo->saveProductOption($productOption);
//        $productRepo->saveCombination($productOption, $option, $optionValue);
    }

    /**
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    private
    function validateFields(array $data)
    {
        $validator = Validator::make($data, [
            'quantity' => 'required',
            'price' => 'required',
            'stock_status' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator;
        }
    }

    public
    function addProductOption($id)
    {
        $product = $this->productRepository->findProductById($id);
        $options = $this->optionRepository->listOptions();

        return view('admin.products.create-options', compact('product', 'options'));
    }

    public
    function storeProductOption(Request $request, $id)
    {

        $product = $this->productRepository->findProductById($id);
        if ($request->has('option_id') && $request->has('option_value_id')) {
            $this->saveProductCombinations($request, $product);
            $request->session()->flash('message', 'Attribute combination created successful');
            return redirect()->route('admin.products.edit', [$id, 'combination' => 1]);
        } else {
            return redirect()->back();
        }
    }


    public
    function editProductOption($id, $oid)
    {
        $product = $this->productRepository->findProductById($id);
        $productOption = ProductOption::findOrFail($oid);

        return view('admin.products.forms.options.edit', compact('product', 'productOption'));
    }


    public
    function updateProductOption(Request $request, $id, $oid)
    {
        try {
            $fields = $request->only('quantity', 'price', 'stock_status');

            if ($errors = $this->validateFields($fields)) {
                return redirect()->route('admin.products.options', [$id])
                    ->withErrors($errors);
            }

            $quantity = $fields['quantity'];
            $price = $fields['price'];
            $stock_status = $fields['stock_status'];

            $productOption = ProductOption::findOrFail($oid);

            $productOption->quantity = (int)$quantity;
            $productOption->price = $price;
            $productOption->stock_status = $stock_status;

            $productOption->save();

            return redirect()->route('admin.products.edit', [$id, 'combination' => 1]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeThumbnail(Request $request, $id, $iid)
    {
        $this->productRepository->deleteThumb($iid);
        return redirect()->back()->with('message', 'Image delete successful');
    }


    public function productDatatables()
    {
        try {
            $products = $this->productRepository->listProducts();
            return Datatables::of($products)
                ->editColumn('product_type', function ($product) {
                    return $product->product_type->name;
                })
                ->addColumn('action', function ($product) {
                    return '<div class="btn-group">
                              <button type="button" class="btn btn-info"><a href="' . route('admin.products.edit', $product->id) . '"><i class="fa fa-fw fa-eye"></i> View</a></button>
                            </div>';
                })->rawColumns(['action', 'product_type'])->make(true);
        } catch (\Exception $e) {
            return null;
        }
    }
}

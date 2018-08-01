<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductOption;
use App\Models\ProductType;
use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use App\Shop\Categories\Repositories\CategoryRepositoryInterface;
use App\Shop\GenericNames\Repositories\GenericNameRepositoryInterface;
use App\Shop\Manufacturers\Repositories\ManufacturerRepositoryInterface;
use App\Shop\Options\Repositories\OptionRepositoryInterface;
use App\Shop\OptionValues\Repositories\OptionValueRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Repositories\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\ProductTypes\Repositories\ProductTypeRepositoryInterface;
use App\Shop\Strengths\Repositories\StrengthRepositoryInterface;
use App\Shop\Tools\UploadableTrait;
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
        ProductTypeRepositoryInterface $productTypeRepository
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
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
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


        dd($product->product_type);


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
    public
    function update(ProductRequest $request, $id)
    {
        return $this->productRepo->update($id, $request->all());
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
    function showAdjust($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

//        $product = Product::findOrFail($id);
        $product = $this->productRepo->getById($id);

        return view('admin.products.adjust', compact('product'));
    }

    public
    function updateAdjust(Request $request, $id)
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


        $option = $this->optionRepo->find($request->option_id);
        $optionValue = $this->optionValueRepo->find($request->option_value_id);


        $productRepo = new ProductRepository($product);

        $productOption = new ProductOption(compact('quantity', 'price', 'stock_status'));
//
        $productOption->option()->associate($option);
        $productOption->optionValue()->associate($optionValue);

//        dd($option, $optionValue, $productOption);

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
        $product = $this->productRepo->getById($id);
        $options = $this->optionRepo->listOptions();

        return view('admin.products.create-options', compact('product', 'options'));
    }

    public
    function storeProductOption(Request $request, $id)
    {

        $product = $this->productRepo->getById($id);
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
        $product = $this->productRepo->getById($id);
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
}

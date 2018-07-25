<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductTypeRequest;
use App\Models\ProductType;
use App\Repositories\ProductType\ProductTypeInterface;
use App\Shop\ProductTypes\Exceptions\CreateProductTypeErrorException;
use App\Shop\ProductTypes\Exceptions\DeleteProductTypeErrorException;
use App\Shop\ProductTypes\Exceptions\UpdateProductTypeErrorException;
use App\Shop\ProductTypes\Repositories\ProductTypeRepository;
use App\Shop\ProductTypes\Repositories\ProductTypeRepositoryInterface;
use DataTables;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * @var ProductTypeRepositoryInterface
     */
    private $productTypeRepository;

    /**
     * ProductTypeController constructor.
     * @param ProductTypeRepositoryInterface $productTypeRepository
     */
    public function __construct(ProductTypeRepositoryInterface $productTypeRepository)
    {
        $this->productTypeRepository = $productTypeRepository;
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
//        $product_types = ProductType::all();
        $product_types = $this->productTypeRepository->listProductTypes();

        return view('admin.product_types.index', compact('product_types'));
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
        return view('admin.product_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductTypeRequest $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        try {
            $product_type = $this->productTypeRepository->createProductType($request->except('_token'));
            flash('Product Type ' . $product_type->name . ' created successfully')->success();
            return redirect()->route('admin.product_types.edit', $product_type->id);
        } catch (CreateProductTypeErrorException $exception) {
            flash($exception->getMessage())->error();

            return redirect()->route('admin.product_types.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $product_type = $this->productTypeRepository->findProductTypeById($id);

        return view('admin.product_types.edit', compact('product_type'));
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
        $product_type = $this->productTypeRepository->findProductTypeById($id);

        return view('admin.product_types.edit', compact('product_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductTypeRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductTypeRequest $request, $id)
    {
        try {
            $product_type = $this->productTypeRepository->findProductTypeById($id);
            $product_typeRepo = new ProductTypeRepository($product_type);

            $product_typeRepo->updateProductType($request->except('_token'));

            flash('Product Type ' . $product_type->name . ' created successfully')->success();

            return redirect()->route('admin.product_types.edit', $id);

        } catch (UpdateProductTypeErrorException $exception) {
            flash($exception->getMessage())->error();
            return redirect()->route('admin.product_types.edit', $id)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        try {
            $product_type = $this->productTypeRepository->findProductTypeById($id);
            $product_typeRepo = new ProductTypeRepository($product_type);

            $status = $product_typeRepo->deleteProductType();

            if ($status) {
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'message' => 'Product Type Successfully Deleted']);
                } else {
                    return redirect()->route('admin.product_types.index');
                }
            }
        } catch (DeleteProductTypeErrorException $exception) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $exception->getMessage()]);
            }
            flash($exception->getMessage())->error();
            return redirect()->back();
        }
    }

    public function dataTable()
    {
        try {
            $product_types = $this->productTypeRepository->listProductTypes();
            return Datatables::of($product_types)
                ->editColumn('name', function (ProductType $product_type) {
                    return '<a href="' . route('admin.product_types.show', $product_type->id) . '">' . $product_type->name . '</a>';
                })
                ->addColumn('action', function (ProductType $product_type) {
                    return '<a id="deleteBtn" data-id="' . $product_type->id . '"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })->rawColumns(['action', 'name'])->make(true);
        } catch (\Exception $e) {
            return null;
        }
    }
}

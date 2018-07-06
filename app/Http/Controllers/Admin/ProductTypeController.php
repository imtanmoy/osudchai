<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductTypeRequest;
use App\Repositories\ProductType\ProductTypeInterface;
use Gate;
use App\Http\Controllers\Controller;

class ProductTypeController extends Controller
{
    private $productType;

    /**
     * ProductTypeController constructor.
     * @param ProductTypeInterface $productType
     */
    public function __construct(ProductTypeInterface $productType)
    {
        $this->productType = $productType;
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
        $product_types = $this->productType->getAll();

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
//        ProductType::create($request->all());
        $this->productType->create($request->all());

        return redirect()->route('admin.product_types.index');
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
//        $product_type = ProductType::findOrFail($id);
        $product_type = $this->productType->getById($id);

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
//        $product_type = ProductType::findOrFail($id);
        $product_type = $this->productType->getById($id);

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
//        $product_type = ProductType::findOrFail($id);
//        $product_type->update($request->all());

        $this->productType->update($id, $request->all());

        return redirect()->route('admin.product_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $this->productType->delete($id);

        return redirect()->route('admin.product_types.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Repositories\Attribute\AttributeInterface;
use App\Http\Controllers\Controller;
use DataTables;
use Gate;
use Request;

class AttributeController extends Controller
{
    private $attribute;

    /**
     * AttributeController constructor.
     * @param AttributeInterface $attribute
     */
    public function __construct(AttributeInterface $attribute)
    {
        $this->attribute = $attribute;
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
        $attributes = $this->attribute->getAll();

//        if ($request->isJson()) {
//            return response()->json($attributes);
//        } else {
        return view('admin.attributes.index', compact('attributes'));
//        }

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
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request)
    {
//        dd($request);
        $this->attribute->create($request->all());
        return redirect()->route('admin.attributes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->attribute->getById($id));
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
        $attribute = $this->attribute->getById($id);

        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, $id)
    {
        $this->attribute->update($id, $request->all());

        return redirect()->route('admin.attributes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        try {
            $attribute = Attribute::findOrFail($id);

            $status = $attribute->delete();

            if ($status) {
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'message' => 'Attribute Successfully Deleted']);
                } else {
                    return redirect()->route('admin.attributes.index');
                }
            }
        } catch (\Exception $exception) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $exception->getMessage()]);
            }
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function showAll()
    {
        $attributes = $this->attribute->getAll();
        return response()->json($attributes);
    }

    public function data_table()
    {
        try {
            $attributes = Attribute::all();
            return Datatables::of($attributes)
                ->editColumn('name', function ($attribute) {
                    return '<a href="' . route('admin.attributes.show', $attribute->id) . '">' . $attribute->name . '</a>';
                })
                ->addColumn('action', function ($attribute) {
                    return '<a id="deleteBtn" data-id="' . $attribute->id . '"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })->rawColumns(['action', 'name'])->make(true);
        } catch (\Exception $e) {
            return null;
        }
    }
}

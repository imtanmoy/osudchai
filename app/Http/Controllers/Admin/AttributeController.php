<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Repositories\Attribute\AttributeInterface;
use App\Http\Controllers\Controller;
use App\Shop\Attributes\Exceptions\CreateAttributeErrorException;
use App\Shop\Attributes\Exceptions\UpdateAttributeErrorException;
use App\Shop\Attributes\Repositories\AttributeRepository;
use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use DataTables;
use Gate;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;


    /**
     * AttributeController constructor.
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        if ($request->has('query')) {
            $strengths = $this->attributeRepository->searchAttribute($request->input('query'));
            $data = $strengths->map(function (Attribute $attribute) {
                return $attribute->name;
            });
            if ($request->ajax()) {
                return response()->json($data);
            } else {
                $attributes = $this->attributeRepository->listAttributes();
                return view('admin.attributes.index', compact('attributes'));
            }

        }
        $attributes = $this->attributeRepository->listAttributes();

        return view('admin.attributes.index', compact('attributes'));

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
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $attribute = $this->attributeRepository->createAttribute($request->except('_token'));
        flash('Attribute ' . $attribute->name . ' created successfully')->success();
        return redirect()->route('admin.attributes.edit', $attribute->id);
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
        return response()->json($this->attributeRepository->findAttributeById($id));
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
        $attribute = $this->attributeRepository->findAttributeById($id);

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
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        try {
            $attribute = $this->attributeRepository->findAttributeById($id);
            $attributeRepo = new AttributeRepository($attribute);
            $attributeRepo->updateAttribute($request->except('_token'));
            flash('Attribute' . $attribute->name . 'created successfully')->success();
            return redirect()->route('admin.attributes.edit', $id);
        } catch (UpdateAttributeErrorException $exception) {
            flash($exception->getMessage())->error();
            return redirect()->route('admin.attributes.edit', $id)->withInput();
        }
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
            $attribute = $this->attributeRepository->findAttributeById($id);

            $attributeRepo = new AttributeRepository($attribute);

            $status = $attributeRepo->deleteAttribute();

            if ($status) {
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'message' => 'Attribute Successfully Deleted']);
                } else {
                    flash('Attribute Successfully Deleted')->success();
                    return redirect()->route('admin.attributes.index');
                }
            }
        } catch (\Exception $exception) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $exception->getMessage()]);
            }
            flash($exception->getMessage())->error();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function showAll()
    {
        $attributes = $this->attributeRepository->listAttributes();
        return response()->json($attributes);
    }

    public function data_table()
    {
        try {
            $attributes = $this->attributeRepository->listAttributes();
            return Datatables::of($attributes)
                ->editColumn('name', function (Attribute $attribute) {
                    return '<a href="' . route('admin.attributes.show', $attribute->id) . '">' . $attribute->name . '</a>';
                })
                ->addColumn('action', function (Attribute $attribute) {
                    return '<a id="deleteBtn" data-id="' . $attribute->id . '"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })->rawColumns(['action', 'name'])->make(true);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function autoComplete(Request $request)
    {
        $data = Attribute::select("name")->where("name", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }
}

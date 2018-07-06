<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use DataTables;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
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
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
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
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        try {
            $inputs = $request->except(['parent_id']);

            $node = new Category($inputs);

            if (!empty($request->parent_id)) {
                if ($request->parent_id != 0) {
                    $node->parent_id = $request->parent_id;
                }
            }
            $node->save();

            flash('Category ' . $node->name . ' created successfully')->success();

            return redirect()->route('admin.categories.index');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage())->withInput();
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
        $category = Category::findOrFail($id);

        $categories = Category::where('id', '!=', $id)->get();

        return view('admin.categories.edit', compact('category', 'categories'));
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
        $category = Category::findOrFail($id);

        $categories = Category::where('id', '!=', $id)->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        try {
            $category = Category::findOrFail($id);

            $inputs = $request->all();

            if (!isset($request->is_active)) {
                $inputs['is_active'] = 0;
            }

            $category->update($inputs);

            flash('Category ' . $category->name . ' updated successfully')->success();

            return redirect()->route('admin.categories.index');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        try {
            $category = Category::findOrFail($id);

            $status = $category->delete();

            if ($status) {
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'message' => 'Category Successfully Deleted']);
                } else {
                    return redirect()->route('admin.categories.index');
                }
            }
        } catch (\Exception $exception) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $exception->getMessage()]);
            }
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    /**
     * @return null
     */
    public function dataTableCategory()
    {
        try {
            $categories = Category::orderBy('order')->get();
            return Datatables::of($categories)
                ->editColumn('name', function ($category) {
                    return '<a href="' . route('admin.categories.show', $category->id) . '">' . $category->name . '</a>';
                })
                ->editColumn('is_active', function ($category) {
                    if ($category->is_active == 0) {
                        return 'No';
                    } else {
                        return 'Yes';
                    }
                })
                ->addColumn('action', function ($category) {
                    return '<a id="deleteBtn" data-id="' . $category->id . '"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })->rawColumns(['action', 'name', 'is_active'])->make(true);
        } catch (\Exception $e) {
            return null;
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PermissionsRequest;
use Gate;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
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
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionsRequest $request)
    {
        try {
            Permission::create($request->all());
        } catch (\Exception $exception) {
            return abort(500);
        }
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionsRequest $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->update($request->all());
        } catch (\Exception $exception) {
            return abort(500);
        }
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
        } catch (\Exception $e) {
            return abort(500);
        }
        return redirect()->route('admin.permissions.index');

    }
}

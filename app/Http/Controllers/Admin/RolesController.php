<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RolesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RolesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(RolesRequest $request)
    {
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param RolesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(RolesRequest $request)
    {
        $permissions = Permission::get()->pluck('name', 'name');

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RolesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesRequest $request)
    {
        try {
            $role = Role::create($request->except('permission'));
            $permissions = $request->input('permission') ? $request->input('permission') : [];
            $role->givePermissionTo($permissions);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param RolesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(RolesRequest $request, $id)
    {
        $permissions = Permission::get()->pluck('name', 'name');

        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RolesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RolesRequest $request, $id)
    {
        $permissions = Permission::get()->pluck('name', 'name');

        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RolesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesRequest $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->update($request->except('permission'));
            $permissions = $request->input('permission') ? $request->input('permission') : [];
            $role->syncPermissions($permissions);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RolesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RolesRequest $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
        return redirect()->route('admin.roles.index');
    }
}

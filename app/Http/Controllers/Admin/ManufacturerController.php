<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ManufacturerRequest;
use App\Models\Manufacturer;
use App\Shop\Manufacturers\Repositories\ManufacturerRepository;
use App\Shop\Manufacturers\Repositories\ManufacturerRepositoryInterface;
use DataTables;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * ManufacturerController constructor.
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     */
    public function __construct(ManufacturerRepositoryInterface $manufacturerRepository)
    {
        $this->manufacturerRepository = $manufacturerRepository;
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
        $manufacturers = $this->manufacturerRepository->listManufacturers();

        return view('admin.manufacturers.index', compact('manufacturers'));
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
        return view('admin.manufacturers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ManufacturerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManufacturerRequest $request)
    {
        try {
            $this->manufacturerRepository->createManufacturer($request->all());
            return redirect()->route('admin.manufacturers.index');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
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
        $manufacturer = $this->manufacturerRepository->findManufacturerById($id);

        return view('admin.manufacturers.edit', compact('manufacturer'));
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
        $manufacturer = $this->manufacturerRepository->findManufacturerById($id);

        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ManufacturerRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManufacturerRequest $request, $id)
    {
        try {
            $manufacturer = $this->manufacturerRepository->findManufacturerById($id);
            $manufacturer->update($request->all());
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
        return redirect()->route('admin.manufacturers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ManufacturerRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManufacturerRequest $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        try {
            $manufacturer = $this->manufacturerRepository->findManufacturerById($id);
            $manufacturerRepo = new ManufacturerRepository($manufacturer);
            $manufacturerRepo->dissociateProducts();
            $status = $manufacturerRepo->deleteManufacturer();
            if ($status) {
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'message' => 'Manufacturer Successfully Deleted']);
                } else {
                    return redirect()->route('admin.manufacturers.index');
                }
            }
        } catch (\Exception $exception) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $exception->getMessage()]);
            }
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function dataTableManufacturer()
    {
        try {
            $manufacturers = $this->manufacturerRepository->listManufacturers();
            return Datatables::of($manufacturers)
                ->editColumn('name', function ($manufacturer) {
                    return '<a href="' . route('admin.manufacturers.show', $manufacturer->id) . '">' . $manufacturer->name . '</a>';
                })
                ->addColumn('action', function ($manufacturer) {
                    return '<a id="deleteBtn" data-id="' . $manufacturer->id . '"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })->rawColumns(['action', 'name'])->make(true);
        } catch (\Exception $e) {
            return null;
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Shop\PackSize\Exceptions\PackSizeNotFoundException;
use App\Shop\PackSize\Exceptions\UpdatePackSizeErrorException;
use App\Shop\PackSize\Repositories\PackSizeRepository;
use App\Shop\PackSize\Repositories\PackSizeRepositoryInterface;
use App\Shop\PackSize\Requests\CreatePackSizeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackSizeController extends Controller
{

    private $packSizeRepo;

    /**
     * PackSizeController constructor.
     * @param $packSizeRepo
     */
    public function __construct(PackSizeRepositoryInterface $packSizeRepo)
    {
        $this->packSizeRepo = $packSizeRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = $this->packSizeRepo->listPackSizes();
        $packSizes = $this->packSizeRepo->paginateArrayResults($results->all());
        return view('admin.packSizes.index', compact('packSizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packSizes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePackSizeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePackSizeRequest $request)
    {
        $packSize = $this->packSizeRepo->createPackSize($request->except('_token'));
        $request->session()->flash('message', 'Create PackSize successful!');

        return redirect()->route('admin.packSizes.edit', $packSize->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $packSize = $this->packSizeRepo->findPackSizeById($id);
            $packSizeRepo = new PackSizeRepository($packSize);

            return view('admin.packSizes.show', [
                'packSize' => $packSize,
                'values' => $packSizeRepo->listPackSizeValues()
            ]);
        } catch (PackSizeNotFoundException $e) {
            request()->session()->flash('error', 'The packSize you are looking for is not found.');

            return redirect()->route('admin.packSizes.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $packSize = $this->packSizeRepo->findPackSizeById($id);

        return view('admin.packSizes.edit', compact('packSize'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $packSize = $this->packSizeRepo->findPackSizeById($id);

            $packSizeRepo = new PackSizeRepository($packSize);
            $packSizeRepo->updatePackSize($request->except('_token'));

            $request->session()->flash('message', 'PackSize update successful!');

            return redirect()->route('admin.packSizes.edit', $packSize->id);
        } catch (UpdatePackSizeErrorException $e) {
            $request->session()->flash('error', $e->getMessage());

            return redirect()->route('admin.packSizes.edit', $id)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->packSizeRepo->findPackSizeById($id)->delete();

        request()->session()->flash('message', 'PackSize deleted successfully!');

        return redirect()->route('admin.packSizes.index');
    }
}

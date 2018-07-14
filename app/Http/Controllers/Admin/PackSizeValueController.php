<?php

namespace App\Http\Controllers\Admin;

use App\Models\PackSizeValue;
use App\Shop\PackSize\Repositories\PackSizeRepository;
use App\Shop\PackSizeValues\Repositories\PackSizeValueRepository;
use App\Shop\PackSizeValues\Requests\CreatePackSizeValueRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackSizeValueController extends Controller
{
    /**
     * @var PackSizeRepository
     */
    private $packSizeRepository;
    /**
     * @var PackSizeValueRepository
     */
    private $packSizeValueRepository;

    /**
     * PackSizeValueController constructor.
     * @param PackSizeRepository $packSizeRepository
     * @param PackSizeValueRepository $packSizeValueRepository
     */
    public function __construct(
        PackSizeRepository $packSizeRepository,
        PackSizeValueRepository $packSizeValueRepository
    )
    {
        $this->packSizeRepository = $packSizeRepository;
        $this->packSizeValueRepository = $packSizeValueRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \App\Shop\PackSize\Exceptions\PackSizeNotFoundException
     */
    public function create($id)
    {
        return view('admin.packSizes-values.create', [
            'packSize' => $this->packSizeRepository->findPackSizeById($id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePackSizeValueRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \App\Shop\PackSize\Exceptions\PackSizeNotFoundException
     */
    public function store(CreatePackSizeValueRequest $request, $id)
    {
        $packSize = $this->packSizeRepository->findPackSizeById($id);

        $packSizeValue = new PackSizeValue($request->except('_token'));

        $packSizeValueRepo = new PackSizeValueRepository($packSizeValue);

        $packSizeValueRepo->associateToPackSize($packSize);

        $request->session()->flash('message', 'PackSize value created');

        return redirect()->route('admin.packSizes.show', $packSize->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $packSizeId
     * @param $packSizeValueId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($packSizeId, $packSizeValueId)
    {
        $packSizeValue = $this->packSizeValueRepository->findOneOrFail($packSizeValueId);

        $packSizeValueRepo = new PackSizeValueRepository($packSizeValue);
        $packSizeValueRepo->dissociateFromPackSize();

        request()->session()->flash('message', 'PackSize value removed!');
        return redirect()->route('admin.packSizes.show', $packSizeId);
    }
}

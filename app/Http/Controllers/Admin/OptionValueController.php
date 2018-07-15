<?php

namespace App\Http\Controllers\Admin;

use App\Models\OptionValue;
use App\Shop\Options\Repositories\OptionRepositoryInterface;
use App\Shop\OptionValues\Repositories\OptionValueRepository;
use App\Shop\OptionValues\Repositories\OptionValueRepositoryInterface;
use App\Shop\OptionValues\Requests\CreateOptionValueRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionValueController extends Controller
{
    private $optionRepo;

    private $optionValueRepo;

    /**
     * OptionValueController constructor.
     * @param OptionRepositoryInterface $optionRepo
     * @param OptionValueRepositoryInterface $optionValueRepo
     */
    public function __construct(OptionRepositoryInterface $optionRepo, OptionValueRepositoryInterface $optionValueRepo)
    {
        $this->optionRepo = $optionRepo;
        $this->optionValueRepo = $optionValueRepo;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.options-values.create', [
            'option' => $this->optionRepo->findOptionById($id)
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateOptionValueRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOptionValueRequest $request, $id)
    {
        $option = $this->optionRepo->findOptionById($id);

        $optionValue = new OptionValue($request->except('_token'));

        $optionValueRepo = new OptionValueRepository($optionValue);

        $optionValueRepo->associateToOption($option);

        $request->session()->flash('message', 'Option Value created');

        return redirect()->route('admin.options.show', $option->id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $optionId
     * @param $optionValueId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($optionId, $optionValueId)
    {
        $optionValue = $this->optionValueRepo->findOneOrFail($optionValueId);

        $optionValueRepo = new OptionValueRepository($optionValue);
        $optionValueRepo->dissociateFromOption();

        request()->session()->flash('message', 'Option value removed!');
        return redirect()->route('admin.options.show', $optionId);
    }


}

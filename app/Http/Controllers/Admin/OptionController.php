<?php

namespace App\Http\Controllers\Admin;

use App\Shop\Options\Exceptions\OptionNotFoundException;
use App\Shop\Options\Exceptions\UpdateOptionErrorException;
use App\Shop\Options\Repositories\OptionRepository;
use App\Shop\Options\Repositories\OptionRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{

    private $optionRepo;

    /**
     * OptionController constructor.
     * @param $optionRepo
     */
    public function __construct(OptionRepositoryInterface $optionRepo)
    {
        $this->optionRepo = $optionRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = $this->optionRepo->listOptions();
        $options = $this->optionRepo->paginateArrayResults($results->all());
        return view('admin.options.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option = $this->optionRepo->createOption($request->except('_token'));
        $request->session()->flash('message', 'Create Option successful!');

        return redirect()->route('admin.options.edit', $option->id);
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
            $option = $this->optionRepo->findOptionById($id);
            $optionRepo = new OptionRepository($option);

            return view('admin.options.show', [
                'option' => $option,
                'values' => $optionRepo->listOptionValues()
            ]);
        } catch (OptionNotFoundException $e) {
            request()->session()->flash('error', 'The Option you are looking for is not found.');

            return redirect()->route('admin.options.index');
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
        $option = $this->optionRepo->findOptionById($id);

        return view('admin.options.edit', compact('option'));
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
            $option = $this->optionRepo->findOptionById($id);

            $optionRepo = new OptionRepository($option);
            $optionRepo->updateOption($request->except('_token'));

            $request->session()->flash('message', 'Option update successful!');

            return redirect()->route('admin.options.edit', $option->id);
        } catch (UpdateOptionErrorException $e) {
            $request->session()->flash('error', $e->getMessage());

            return redirect()->route('admin.options.edit', $id)->withInput();
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
        $this->optionRepo->findOptionById($id)->delete();

        request()->session()->flash('message', 'Option deleted successfully!');

        return redirect()->route('admin.options.index');
    }
}

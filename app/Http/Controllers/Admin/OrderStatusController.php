<?php

namespace App\Http\Controllers\Admin;

use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepositoryInterface;
use App\Shop\OrderStatuses\Requests\CreateOrderStatusRequest;
use App\Shop\OrderStatuses\Requests\UpdateOrderStatusRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatusController extends Controller
{

    private $orderStatusRepo;

    /**
     * OrderStatusController constructor.
     * @param OrderStatusRepositoryInterface $orderStatusRepository
     */
    public function __construct(OrderStatusRepositoryInterface $orderStatusRepository)
    {
        $this->orderStatusRepo = $orderStatusRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order-statuses.index', ['orderStatuses' => $this->orderStatusRepo->listOrderStatuses()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.order-statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateOrderStatusRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderStatusRequest $request)
    {
        $this->orderStatusRepo->createOrderStatus($request->except('_token', '_method'));
        $request->session()->flash('message', 'Create successful');
        return redirect()->route('admin.order-statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.order-statuses.edit', ['orderStatus' => $this->orderStatusRepo->findOrderStatusById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderStatusRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \App\Shop\OrderStatuses\Exceptions\OrderStatusInvalidArgumentException
     */
    public function update(UpdateOrderStatusRequest $request, $id)
    {
        $orderStatus = $this->orderStatusRepo->findOrderStatusById($id);

        $update = new OrderStatusRepository($orderStatus);
        $update->updateOrderStatus($request->all());

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.order-statuses.edit', $id);
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
        $this->orderStatusRepo->findOrderStatusById($id)->delete();

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.order-statuses.index');
    }
}

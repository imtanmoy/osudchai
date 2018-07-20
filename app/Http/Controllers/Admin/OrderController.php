<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Shop\Orders\Repositories\OrderRepositoryInterface;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepositoryInterface;
use DataTables;
use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    private $orderStatusRepo;
    private $orderRepo;

    /**
     * OrderController constructor.
     * @param OrderStatusRepositoryInterface $orderStatusRepo
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        OrderStatusRepositoryInterface $orderStatusRepo,
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->orderStatusRepo = $orderStatusRepo;
        $this->orderRepo = $orderRepository;
    }


    public function index()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        return view('admin.orders.index');
    }

    public function show($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $order = Order::findOrFail($id);


        $orderStatuses = $this->orderStatusRepo->listOrderStatuses();

        return view('admin.orders.show', compact('order', 'orderStatuses'));
    }

    public function datatable()
    {
        try {
            $orders = Order::all();
            return Datatables::of($orders)
//                ->editColumn('order_no', function ($order) {
//                    return '<a href="' . route('admin.orders.show', $order->id) . '">' . $order->order_no . '</a>';
//                })
                ->editColumn('payment_status', function ($order) {
                    if ($order->payment == null || $order->payment->payment_status == 0) {
                        return 'No';
                    } else {
                        return 'Yes';
                    }
                })
                ->editColumn('shipping_status', function ($order) {
                    if ($order->shipping_status == 0) {
                        return 'No';
                    } else {
                        return 'Yes';
                    }
                })
                ->addColumn('action', function ($order) {
//                    return '<a id="deleteBtn" data-id="' . $order->id . '"  class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                    return '<div class="btn-group">
                              <button type="button" class="btn btn-success"><a href="' . route('admin.orders.show', $order->id) . '"><i class="fa fa-fw fa-eye"></i></a></button>
                              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-fw fa-edit"></i>Edit</a></li>
                                <li><a href="#"><i class="fa fa-fw fa-edit"></i>Delete</a></li>
                              </ul>
                            </div>';
                })->rawColumns(['action', 'payment_status', 'shipping_status'])->make(true);
        } catch (\Exception $e) {
            return null;
        }
    }


    public function delivery($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $order = Order::findOrFail($id);

//        dd($order->method);

        return view('admin.orders.delivery', compact('order'));
    }

    public function addStatus(Request $request, $id)
    {
        $order = $this->orderRepo->findOneOrFail($id);
        $orderStatus = $this->orderStatusRepo->findOrderStatusById($request->order_status_id);
        $order->statuses()->attach($orderStatus, ['comment' => $request->comment]);
        return redirect()->back();
    }
}

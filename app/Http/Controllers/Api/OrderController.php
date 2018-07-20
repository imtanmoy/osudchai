<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Repositories\Product\ProductInterface;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\AddressRepositoryInterface;
use App\Shop\OrderItems\Repositories\OrderItemRepository;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Orders\Repositories\OrderRepositoryInterface;
use App\Shop\PaymentMethods\Repositories\PaymentMethodRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    private $orderRepo;
    private $addressRepo;
    private $productRepo;
    private $paymentMethodRepo;

    /**
     * OrderController constructor.
     * @param OrderRepositoryInterface $orderRepository
     * @param AddressRepositoryInterface $addressRepository
     * @param ProductInterface $product
     * @param PaymentMethodRepositoryInterface $paymentMethodRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        AddressRepositoryInterface $addressRepository,
        ProductInterface $product,
        PaymentMethodRepositoryInterface $paymentMethodRepository
    )
    {
        $this->orderRepo = $orderRepository;
        $this->addressRepo = $addressRepository;
        $this->productRepo = $product;
        $this->paymentMethodRepo = $paymentMethodRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(auth('api')->user()->orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $items = [];
            $total_amount = 0.0;
            $sub_total = 0.0;
            $discount_amount = $request->discount_amount ? $request->discount_amount : 0.0;
            $shipping_cost = $request->shipping_cost ? $request->shipping_cost : 50.0;
            $tax = $request->tax ? $request->tax : 5;
            if (isset($request->products) && !empty($request->products)) {
                $prods = $request->products;

                foreach ($prods as $prod) {
                    $product = $this->productRepo->getById($prod['id']);
                    $item['quantity'] = $prod['quantity'];
                    $item['name'] = $product->name;
                    $item['unit_price'] = $product->price;
                    $item['product_id'] = $product->id;
                    if (isset($prod['option']) && $prod['option'] !== null && $prod['option'] !== 0) {
                        $productOption = $product->options()->where('product_options.id', $prod['option'])->first();
                        $item['product_option_id'] = $productOption->id;
                        $item['unit_price'] = $productOption->price;
                    }
                    $discount = 0.0;
                    $item['discount_amount'] = $discount;
                    array_push($items, $item);
                    $sub_total = $sub_total + (($item['unit_price'] - $item['discount_amount']) * $item['quantity']);
                }
                if ($sub_total < 0) {
                    $sub_total = 0;
                    $total_amount = $sub_total + $shipping_cost + $tax;
                } else {
                    $total_amount = ($sub_total - $discount_amount) + $shipping_cost + $tax;
                }

                $data['total_amount'] = $total_amount;
                $data['sub_total'] = $sub_total;
                $data['discount_amount'] = $discount_amount;
                $data['tax'] = $this->calculateTax($data['total_amount'], 5);
                $data['customer_comment'] = $request->customer_comment ? $request->customer_comment : '';


                $paymentMethod = $this->paymentMethodRepo->findOneOrFail($request->payment_method);
                $address = $this->addressRepo->findOneOrFail($request->address);
                $user = auth('api')->user();

                $data['payment_method_id'] = $paymentMethod->id;
                $data['address_id'] = $address->id;
                $data['user_id'] = $user->id;

                $order = $this->orderRepo->createOrder($data);

                foreach ($items as $item) {
                    $orderItem = new OrderItem($item);
                    $orderItemRepo = new OrderItemRepository($orderItem);
                    $orderItemRepo->associateToOrder($order);
                }

            } else {
                return response()->json(['message' => 'No Product added to the cart'], 400);
            }
            return response()->json($order);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function calculateTax($amount, $tax)
    {
        $taxValue = $tax / 100;
        $newTax = $amount * $taxValue;
        return $newTax;
    }
}

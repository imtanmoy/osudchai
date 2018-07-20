<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 1:41 PM
 */

namespace App\Shop\Orders\Repositories;


use App\Events\OrderCreateEvent;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Shop\Base\BaseRepository;
use App\Shop\Orders\Exceptions\OrderInvalidArgumentException;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    protected $model;

    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->model = $order;
    }


    public function createOrder(array $data): Order
    {
        try {
            $data['order_no'] = $this->generateOrderNumber();

            $order = $this->create($data);

            $orderStatus = OrderStatus::firstOrNew(['name' => 'pending']);

            $order->statuses()->save($orderStatus);

            return $order;
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    public function updateOrder(array $update): Order
    {
        // TODO: Implement updateOrder() method.
    }

    public function findOrderById(int $id): Order
    {
        // TODO: Implement findOrderById() method.
    }

    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        // TODO: Implement listOrders() method.
    }

    public function findProducts(Order $order): Collection
    {
        // TODO: Implement findProducts() method.
    }

    public function associateProduct(Product $product, int $quantity)
    {
        // TODO: Implement associateProduct() method.
    }

    public function searchOrder(string $text): Collection
    {
        // TODO: Implement searchOrder() method.
    }

    public function listOrderedProducts(): Collection
    {
        // TODO: Implement listOrderedProducts() method.
    }

    public function buildOrderDetails(Collection $items)
    {
        // TODO: Implement buildOrderDetails() method.
    }

    /**
     * @return string
     */
    private function generateOrderNumber()
    {
        $lastOrder = $this->model->orderBy('id', 'desc')->limit(1)->first();
        $last = $lastOrder ? $lastOrder->id : 0;
        $next = 1 + $last;
        return strtoupper('#' . str_pad($last + 1, 6, "0", STR_PAD_LEFT));
    }

    private function calculateTax($amount, $tax)
    {
        $taxValue = $tax / 100;
        $newTax = $amount * $taxValue;
        return $newTax;
    }

    public function associateToAddress(Address $address): Order
    {
        $this->model->address()->associate($address);
        $this->model->save();
        return $this->model;
    }

    public function associateToPaymentMethod(PaymentMethod $paymentMethod): Order
    {
        $this->model->method()->associate($paymentMethod);
        $this->model->save();
        return $this->model;
    }

    public function associateToUser(User $user): Order
    {
        $this->model->user()->associate($user);
        $this->model->save();
        return $this->model;
    }
}

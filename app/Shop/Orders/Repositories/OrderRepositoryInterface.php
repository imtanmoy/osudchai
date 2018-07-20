<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 1:40 PM
 */

namespace App\Shop\Orders\Repositories;


use App\Models\Address;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\User;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrder(array $data): Order;

    public function updateOrder(array $update): Order;

    public function findOrderById(int $id): Order;

    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection;

    public function findProducts(Order $order): Collection;

    public function associateProduct(Product $product, int $quantity);

    public function searchOrder(string $text): Collection;

    public function listOrderedProducts(): Collection;

    public function buildOrderDetails(Collection $items);

    public function associateToAddress(Address $address): Order;

    public function associateToPaymentMethod(PaymentMethod $paymentMethod): Order;

    public function associateToUser(User $user): Order;
}

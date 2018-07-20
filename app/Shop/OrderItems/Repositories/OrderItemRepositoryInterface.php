<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 7:09 PM
 */

namespace App\Shop\OrderItems\Repositories;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface OrderItemRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderItem(Order $order, array $data): OrderItem;

    public function associateToOrder(Order $order): OrderItem;

    public function dissociateFromOrder(): bool;

    public function findProduct(): Product;
}

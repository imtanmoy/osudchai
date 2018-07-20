<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 9:42 PM
 */

namespace App\Shop\OrderStatuses\Repositories;


use App\Models\OrderStatus;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface OrderStatusRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderStatus(array $orderStatusData): OrderStatus;

    public function updateOrderStatus(array $update): OrderStatus;

    public function findOrderStatusById(int $id): OrderStatus;

    public function listOrderStatuses();

    public function deleteOrderStatus(OrderStatus $os): bool;

    public function findOrders(): Collection;
}

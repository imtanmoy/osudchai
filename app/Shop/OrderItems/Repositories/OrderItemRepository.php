<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 7:12 PM
 */

namespace App\Shop\OrderItems\Repositories;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Shop\Base\BaseRepository;

class OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
{

    protected $model;

    /**
     * OrderItemRepository constructor.
     * @param OrderItem $orderItem
     */
    public function __construct(OrderItem $orderItem)
    {
        parent::__construct($orderItem);
        $this->model = $orderItem;
    }


    public function createOrderItem(Order $order, array $data): OrderItem
    {
        $orderItem = new OrderItem($data);
        $orderItem->order()->associate($order);
        $orderItem->save();
        return $orderItem;
    }

    public function associateToOrder(Order $order): OrderItem
    {
        $this->model->order()->associate($order);
        $this->model->save();
        return $this->model;
    }

    public function dissociateFromOrder(): bool
    {
        return $this->model->order()->delete();
    }

    public function findProduct(): Product
    {
        $this->model->product()->get();
    }
}

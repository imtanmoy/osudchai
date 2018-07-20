<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 9:42 PM
 */

namespace App\Shop\OrderStatuses\Repositories;


use App\Models\OrderStatus;
use App\Shop\Base\BaseRepository;
use App\Shop\OrderStatuses\Exceptions\OrderStatusInvalidArgumentException;
use App\Shop\OrderStatuses\Exceptions\OrderStatusNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class OrderStatusRepository extends BaseRepository implements OrderStatusRepositoryInterface
{

    protected $model;

    /**
     * OrderStatusRepository constructor.
     * @param OrderStatus $orderStatus
     */
    public function __construct(OrderStatus $orderStatus)
    {
        parent::__construct($orderStatus);
        $this->model = $orderStatus;
    }

    /**
     * @param array $params
     * @return OrderStatus
     * @throws OrderStatusInvalidArgumentException
     */
    public function createOrderStatus(array $params): OrderStatus
    {
        try {
            return $this->create($params);
        } catch (QueryException $e) {
            throw new OrderStatusInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $update
     * @return OrderStatus
     * @throws OrderStatusInvalidArgumentException
     */
    public function updateOrderStatus(array $update): OrderStatus
    {
        try {
            $this->update($update, $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new OrderStatusInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return OrderStatus
     * @throws OrderStatusNotFoundException
     */
    public function findOrderStatusById(int $id): OrderStatus
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new OrderStatusNotFoundException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function listOrderStatuses()
    {
        return $this->all();
    }

    /**
     * @param OrderStatus $os
     * @return bool
     */
    public function deleteOrderStatus(OrderStatus $os): bool
    {
        return $this->delete($os->id);
    }

    /**
     * @return Collection
     */
    public function findOrders(): Collection
    {
        return $this->model->orders()->get();
    }
}

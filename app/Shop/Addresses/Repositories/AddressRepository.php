<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 4:54 PM
 */

namespace App\Shop\Addresses\Repositories;


use App\Models\Address;
use App\Models\Area;
use App\Models\City;
use App\Shop\Addresses\Exceptions\AddressInvalidArgumentException;
use App\Shop\Addresses\Exceptions\AddressNotFoundException;
use App\Shop\Base\BaseRepository;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    protected $model;

    /**
     * AddressRepository constructor.
     * @param Address $address
     */
    public function __construct(Address $address)
    {
        parent::__construct($address);
        $this->model = $address;
    }


    public function createAddress(array $params): Address
    {
        try {
            $address = new Address($params);
            if (isset($params['user'])) {
                $address->user()->associate($params['user']);
            }
            $address->save();

            return $address;
        } catch (QueryException $e) {
            throw new AddressInvalidArgumentException('Address creation error', 500, $e);
        }
    }

    /**
     * Attach the customer to the address
     *
     * @param Address $address
     * @param User $user
     */
    public function attachToUser(Address $address, User $user)
    {
        $user->addresses()->save($address);
    }

    /**
     * @param array $update
     * @return bool
     */
    public function updateAddress(array $update): bool
    {
        return $this->model->update($update);
    }


    /**
     * @return bool|null
     * @throws \Exception
     */
    public function deleteAddress()
    {
        $this->model->user()->dissociate();
        return $this->model->delete();
    }


    /**
     * List all the address
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return array|Collection
     */
    public function listAddress(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->all($columns, $order, $sort);
    }

    public function findAddressById(int $id): Address
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new AddressNotFoundException($e->getMessage());
        }
    }

    public function findUser(): User
    {
        return $this->model->user;
    }

    public function searchAddress(string $text): Collection
    {
        return $this->model->search($text, [
            'address1' => 10,
            'address2' => 5,
            'area.name' => 5,
            'city.name' => 5
        ])->get();
    }

    public function findArea(): Area
    {
        return $this->model->area;
    }

    public function findCity(): City
    {
        return $this->model->city;
    }

    /**
     * @return Collection
     */
    public function findOrders(): Collection
    {
        return $this->model->orders()->get();
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/21/2018
 * Time: 11:41 AM
 */

namespace App\Shop\Users\Repositories;


use App\Models\Address;
use App\Shop\Base\BaseRepository;
use App\Shop\Users\Exceptions\CreateUserInvalidArgumentException;
use App\Shop\Users\Exceptions\UpdateUserInvalidArgumentException;
use App\Shop\Users\Exceptions\UserNotFoundException;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection as Support;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    protected $model;

    /**
     * CustomerRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;
    }

    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Support
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param array $params
     * @return User
     * @throws CreateUserInvalidArgumentException
     */
    public function createUser(array $params): User
    {
        try {
            $data = collect($params)->except('password')->all();
            $user = new User($data);
            if (isset($params['password'])) {
                $user->password = bcrypt($params['password']);
            }
            $user->save();
            return $user;
        } catch (QueryException $e) {
            throw new CreateUserInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * @param array $params
     * @return bool
     * @throws UpdateUserInvalidArgumentException
     */
    public function updateUser(array $params): bool
    {
        try {
            return $this->model->update($params);
        } catch (QueryException $e) {
            throw new UpdateUserInvalidArgumentException($e);
        }
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserById(int $id): User
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteUser(): bool
    {
        return $this->model->delete();
    }

    public function attachAddress(Address $address): Address
    {
        $this->model->addresses()->save($address);
        return $address;
    }

    /**
     * @return Collection
     */
    public function findAddresses(): Support
    {
        return $this->model->addresses;
    }

    public function findOrders(): Collection
    {
        return $this->model->orders()->get();
    }

    public function searchUser(string $text): Collection
    {
        // TODO: Implement searchUser() method.
    }

    public function charge(int $amount, array $options)
    {
        // TODO: Implement charge() method.
    }

    public function getAddresses(): Collection
    {
        return $this->model->addresses;
    }
}

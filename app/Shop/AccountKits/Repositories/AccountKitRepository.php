<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/26/18
 * Time: 9:52 AM
 */

namespace App\Shop\AccountKits\Repositories;


use App\Models\AccountKit;
use App\Shop\Base\BaseRepository;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class AccountKitRepository extends BaseRepository implements AccountKitRepositoryInterface
{

    protected $model;

    /**
     * AccountKitRepository constructor.
     * @param AccountKit $accountKit
     */
    public function __construct(AccountKit $accountKit)
    {
        parent::__construct($accountKit);
        $this->model = $accountKit;
    }

    /**
     * @param array $params
     * @return AccountKit
     */
    public function createAccountKit(array $params): AccountKit
    {
        try {
            $accountKit = new AccountKit($params);
            if (isset($params['user_id'])) {
                $accountKit->user()->associate($params['user_id']);
            }
            $accountKit->save();

            $accountKit->user()->update([
                'is_phone_verified' => 1,
                'is_verified' => 1,
            ]);

            return $accountKit;
        } catch (QueryException $e) {
            throw $e;
        }
    }

    /**
     * @param AccountKit $accountKit
     * @param User $user
     */
    public function attachToUser(AccountKit $accountKit, User $user)
    {
        $user->accountKit()->save($accountKit);
        $user->update([
            'is_phone_verified' => 1,
            'is_verified' => 1,
        ]);
    }

    /**
     * @param array $update
     * @return bool
     */
    public function updateAccountKit(array $update): bool
    {
        return $this->model->update($update);
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function deleteAccountKit()
    {
        $this->model->user()->dissociate();
        return $this->model->delete();
    }

    public function listAccountKit(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->all($columns, $order, $sort);
    }

    public function findAccountKitById(int $id): AccountKit
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function findUser(): User
    {
        return $this->model->user;
    }

    public function searchAccountKit(string $text): Collection
    {
//        return $this->model->search($text, [
//            'address1' => 10,
//            'address2' => 5,
//            'area.name' => 5,
//            'city.name' => 5
//        ])->get();
    }

    public function findAccountKitByNumber(string $number)
    {
        return $this->model->where('number', '=', $number)->first();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/26/18
 * Time: 9:51 AM
 */

namespace App\Shop\AccountKits\Repositories;


use App\Models\AccountKit;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\User;
use Illuminate\Support\Collection;

interface AccountKitRepositoryInterface extends BaseRepositoryInterface
{
    public function createAccountKit(array $params): AccountKit;

    public function attachToUser(AccountKit $accountKit, User $user);

    public function updateAccountKit(array $update): bool;

    public function deleteAccountKit();

    public function listAccountKit(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection;

    public function findAccountKitById(int $id): AccountKit;

    public function findAccountKitByNumber(string $number);

    public function findUser(): User;

    public function searchAccountKit(string $text): Collection;

    public function verify(string $code): AccountKit;
}
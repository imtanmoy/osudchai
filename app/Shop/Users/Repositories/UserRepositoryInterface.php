<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/21/2018
 * Time: 11:39 AM
 */

namespace App\Shop\Users\Repositories;


use App\Models\Address;
use App\Models\Prescription;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\User;
use Illuminate\Support\Collection as Support;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Support;

    public function createUser(array $params): User;

    public function updateUser(array $params): bool;

    public function findUserById(int $id): User;

    public function deleteUser(): bool;

    public function attachAddress(Address $address): Address;

    public function findAddresses(): Support;

    public function getAddresses(): Support;

    public function findOrders(): Collection;

    public function searchUser(string $text): Collection;

    public function charge(int $amount, array $options);

    public function attachPrescription(Prescription $prescription): Prescription;

    public function getPrescriptions();
}

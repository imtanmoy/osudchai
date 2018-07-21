<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 4:55 PM
 */

namespace App\Shop\Addresses\Repositories;


use App\Models\Address;
use App\Models\Area;
use App\Models\City;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\User;
use Illuminate\Support\Collection;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function createAddress(array $params) : Address;

    public function attachToUser(Address $address, User $user);

    public function updateAddress(array $update): bool;

    public function deleteAddress();

    public function listAddress(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function findAddressById(int $id) : Address;

    public function findUser() : User;

    public function searchAddress(string $text) : Collection;

//    public function findCountry() : Country;

    public function findArea() : Area;

    public function findCity() : City;
}

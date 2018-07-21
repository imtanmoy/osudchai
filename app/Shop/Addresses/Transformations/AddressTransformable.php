<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/21/2018
 * Time: 11:30 AM
 */

namespace App\Shop\Addresses\Transformations;


use App\Models\Address;
use App\Shop\Users\Repositories\UserRepository;
use App\User;

trait AddressTransformable
{
    /**
     * Transform the address
     *
     * @param Address $address
     * @return Address
     */
    public function transformAddress(Address $address)
    {
        $obj = new Address;
        $obj->id = $address->id;
        $obj->address_1 = $address->address1;
        $obj->address_2 = $address->address2;
        $obj->post_code = $address->post_code;

        if (isset($address->city_id)) {
            $obj->city = $address->city->name;
        }

        if (isset($address->area_id)) {
            $obj->area = $address->area->name;
        }

        $userRepo = new UserRepository(new User);
        $user = $userRepo->findOneOrFail($address->user_id);
        $obj->user = $user->name;

        return $obj;
    }
}

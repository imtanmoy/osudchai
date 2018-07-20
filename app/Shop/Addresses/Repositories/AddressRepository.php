<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 4:54 PM
 */

namespace App\Shop\Addresses\Repositories;


use App\Models\Address;
use App\Shop\Base\BaseRepository;

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


}

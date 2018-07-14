<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/14/2018
 * Time: 12:14 PM
 */

namespace App\Shop\PackSizeValues\Repositories;


use App\Models\PackSize;
use App\Models\PackSizeValue;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface PackSizeValueRepositoryInterface extends BaseRepositoryInterface
{
    public function createPackSizeValue(PackSize $attribute, array $data) : PackSizeValue;

    public function associateToPackSize(PackSize $attribute) : PackSizeValue;

    public function dissociateFromPackSize() : bool;

    public function findProductPackSizes() : Collection;
}

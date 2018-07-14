<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/14/2018
 * Time: 12:15 PM
 */

namespace App\Shop\PackSizeValues\Repositories;


use App\Models\PackSize;
use App\Models\PackSizeValue;
use App\Shop\Base\BaseRepository;
use Illuminate\Support\Collection;

class PackSizeValueRepository extends BaseRepository implements PackSizeValueRepositoryInterface
{
    /**
     * @var $model
     */
    protected $model;


    /**
     * PackSizeValueRepository constructor.
     * @param PackSizeValue $packSizeValue
     */
    public function __construct(PackSizeValue $packSizeValue)
    {
        parent::__construct($packSizeValue);
        $this->model = $packSizeValue;
    }

    public function createPackSizeValue(PackSize $packSize, array $data): PackSizeValue
    {
        $packSizeValue = new PackSizeValue($data);
        $packSizeValue->packSize()->associate($packSize);
        $packSizeValue->save();
        return $packSizeValue;
    }

    public function associateToPackSize(PackSize $packSize): PackSizeValue
    {
        $this->model->packSize()->associate($packSize);
        $this->model->save();
        return $this->model;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function dissociateFromPackSize(): bool
    {
        return $this->model->delete();
    }

    public function findProductPackSizes(): Collection
    {
        return $this->model->productPackSizes()->get();
    }
}

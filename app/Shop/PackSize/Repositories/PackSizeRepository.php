<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/14/2018
 * Time: 10:46 AM
 */

namespace App\Shop\PackSize\Repositories;


use App\Models\PackSize;
use App\Models\PackSizeValue;
use App\Shop\Base\BaseRepository;
use App\Shop\PackSize\Exceptions\PackSizeNotFoundException;
use App\Shop\PackSize\Exceptions\UpdatePackSizeErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use App\Shop\PackSize\Exceptions\CreatePackSizeErrorException;

class PackSizeRepository extends BaseRepository implements PackSizeRepositoryInterface
{

    protected $model;

    /**
     * PackSizeRepository constructor.
     * @param PackSize $packSize
     */
    public function __construct(PackSize $packSize)
    {
        parent::__construct($packSize);
        $this->model = $packSize;
    }


    /**
     * @param array $data
     * @return PackSize
     * @throws CreatePackSizeErrorException
     */
    public function createPackSize(array $data): PackSize
    {
        try {
            $packSize = new PackSize($data);
            $packSize->save();
            return $packSize;
        } catch (QueryException $e) {
            throw new CreatePackSizeErrorException($e);
        }
    }

    /**
     * @param int $id
     * @return PackSize
     * @throws PackSizeNotFoundException
     */
    public function findPackSizeById(int $id): PackSize
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PackSizeNotFoundException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdatePackSizeErrorException
     */
    public function updatePackSize(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdatePackSizeErrorException($e);
        }
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function deletePackSize(): ?bool
    {
        return $this->model->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function listPackSizes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @return Collection
     */
    public function listPackSizeValues(): Collection
    {
        return $this->model->values()->get();
    }

    /**
     * @param PackSizeValue $attributeValue
     * @return PackSizeValue
     */
    public function associatePackSizeValue(PackSizeValue $attributeValue): PackSizeValue
    {
        return $this->model->values()->save($attributeValue);
    }
}

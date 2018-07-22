<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/22/18
 * Time: 6:05 PM
 */

namespace App\Shop\Manufacturers\Repositories;


use App\Models\Manufacturer;
use App\Models\Product;
use App\Shop\Base\BaseRepository;
use App\Shop\Manufacturers\Exceptions\CreateManufacturerErrorException;
use App\Shop\Manufacturers\Exceptions\ManufacturerNotFoundErrorException;
use App\Shop\Manufacturers\Exceptions\UpdateManufacturerErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ManufacturerRepository extends BaseRepository implements ManufacturerRepositoryInterface
{

    protected $model;

    /**
     * ManufacturerRepository constructor.
     * @param Manufacturer $manufacturer
     */
    public function __construct(Manufacturer $manufacturer)
    {
        $this->model = $manufacturer;
    }


    /**
     * @param array $data
     * @return Manufacturer
     * @throws CreateManufacturerErrorException
     */
    public function createManufacturer(array $data): Manufacturer
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateManufacturerErrorException($e);
        }

    }

    /**
     * @param int $id
     * @return Manufacturer
     * @throws ManufacturerNotFoundErrorException
     */
    public function findManufacturerById(int $id): Manufacturer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ManufacturerNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdateManufacturerErrorException
     */
    public function updateManufacturer(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateManufacturerErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteManufacturer(): bool
    {
        return $this->model->delete();
    }

    public function listManufacturers($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }


    /**
     * @return Collection
     */
    public function listProducts(): Collection
    {
        return $this->model->products()->get();
    }


    public function saveProduct(Product $product)
    {
        $this->model->products()->save($product);
    }


    /**
     * Dissociate the products
     */
    public function dissociateProducts()
    {
        $this->model->products()->each(function (Product $product) {
            $product->manufacturer_id = null;
            $product->save();
        });
    }
}
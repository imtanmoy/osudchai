<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/24/18
 * Time: 10:28 AM
 */

namespace App\Shop\GenericNames\Repositories;


use App\Models\GenericName;
use App\Models\Product;
use App\Shop\Base\BaseRepository;
use App\Shop\GenericNames\Exceptions\CreateGenericNameErrorException;
use App\Shop\GenericNames\Exceptions\GenericNameNotFoundErrorException;
use App\Shop\GenericNames\Exceptions\UpdateGenericNameErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class GenericNameRepository extends BaseRepository implements GenericNameRepositoryInterface
{

    protected $model;

    /**
     * GenericNameRepository constructor.
     * @param GenericName $genericName
     */
    public function __construct(GenericName $genericName)
    {
        parent::__construct($genericName);
        $this->model = $genericName;
    }


    /**
     * @param array $data
     * @return GenericName
     * @throws CreateGenericNameErrorException
     */
    public function createGenericName(array $data): GenericName
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateGenericNameErrorException($e);
        }
    }

    /**
     * @param int $id
     * @return GenericName
     * @throws GenericNameNotFoundErrorException
     */
    public function findGenericNameById(int $id): GenericName
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new GenericNameNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdateGenericNameErrorException
     */
    public function updateGenericName(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateGenericNameErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteGenericName(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function listGenericNames($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @param Product $product
     */
    public function saveProduct(Product $product)
    {
        $this->model->products()->save($product);
    }

    /**
     * @param string $text
     * @return Collection
     */
    public function searchGenericName(string $text): Collection
    {
        return $this->model->search($text, [
            'name' => 10
        ])->get();
    }

    /**
     * @return Collection
     */
    public function listProducts(): Collection
    {
        return $this->model->products()->get();
    }

    /**
     * Dissociate the products
     */
    public function dissociateProducts()
    {
        $this->model->products()->each(function (Product $product) {
            $product->generic_name_id = null;
            $product->save();
        });
    }
}
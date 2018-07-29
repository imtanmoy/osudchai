<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/24/18
 * Time: 11:05 AM
 */

namespace App\Shop\Strengths\Repositories;


use App\Models\Product;
use App\Models\Strength;
use App\Shop\Base\BaseRepository;
use App\Shop\Strengths\Exceptions\CreateStrengthErrorException;
use App\Shop\Strengths\Exceptions\StrengthNotFoundErrorException;
use App\Shop\Strengths\Exceptions\UpdateStrengthErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class StrengthRepository extends BaseRepository implements StrengthRepositoryInterface
{
    protected $model;


    /**
     * StrengthRepository constructor.
     * @param Strength $strength
     */
    public function __construct(Strength $strength)
    {
        parent::__construct($strength);
        $this->model = $strength;
    }

    /**
     * @param array $data
     * @return Strength
     * @throws CreateStrengthErrorException
     */
    public function createStrength(array $data): Strength
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateStrengthErrorException($e);
        }
    }

    /**
     * @param int $id
     * @return Strength
     * @throws StrengthNotFoundErrorException
     */
    public function findStrengthById(int $id): Strength
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new StrengthNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdateStrengthErrorException
     */
    public function updateStrength(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateStrengthErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteStrength(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function listStrengths($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
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

    public function searchStrength(string $text): Collection
    {
        return $this->model->search($text, [
            'value' => 10
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
            $product->strength_id = null;
            $product->save();
        });
    }
}
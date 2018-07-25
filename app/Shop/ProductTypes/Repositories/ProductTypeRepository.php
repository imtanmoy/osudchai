<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/25/18
 * Time: 10:17 AM
 */

namespace App\Shop\ProductTypes\Repositories;


use App\Models\Product;
use App\Models\ProductType;
use App\Shop\Base\BaseRepository;
use App\Shop\ProductTypes\Exceptions\CreateProductTypeErrorException;
use App\Shop\ProductTypes\Exceptions\DeleteProductTypeErrorException;
use App\Shop\ProductTypes\Exceptions\ProductTypeNotFoundErrorException;
use App\Shop\ProductTypes\Exceptions\UpdateProductTypeErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ProductTypeRepository extends BaseRepository implements ProductTypeRepositoryInterface
{
    protected $model;

    /**
     * ProductTypeRepository constructor.
     * @param ProductType $productType
     */
    public function __construct(ProductType $productType)
    {
        parent::__construct($productType);
        $this->model = $productType;
    }

    /**
     * @param array $data
     * @return ProductType
     * @throws CreateProductTypeErrorException
     */
    public function createProductType(array $data): ProductType
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateProductTypeErrorException($e);
        }
    }

    /**
     * @param int $id
     * @return ProductType
     * @throws ProductTypeNotFoundErrorException
     */
    public function findProductTypeById(int $id): ProductType
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProductTypeNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdateProductTypeErrorException
     */
    public function updateProductType(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateProductTypeErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws DeleteProductTypeErrorException
     */
    public function deleteProductType(): bool
    {
        try {
            return $this->model->delete();
        } catch (\Exception $e) {
            throw new DeleteProductTypeErrorException($e);
        }
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function listProductTypes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
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

    public function searchProductType(string $text): Collection
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
            $product->product_type_id = null;
            $product->save();
        });
    }
}
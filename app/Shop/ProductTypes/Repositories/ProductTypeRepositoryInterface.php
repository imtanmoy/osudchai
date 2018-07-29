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
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface ProductTypeRepositoryInterface extends BaseRepositoryInterface
{
    public function createProductType(array $data): ProductType;

    public function findProductTypeById(int $id): ProductType;

    public function updateProductType(array $data): bool;

    public function deleteProductType(): bool;

    public function listProductTypes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    public function saveProduct(Product $product);

    public function searchProductType(string $text): Collection;

}
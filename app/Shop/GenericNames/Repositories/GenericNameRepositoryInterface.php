<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/24/18
 * Time: 10:27 AM
 */

namespace App\Shop\GenericNames\Repositories;


use App\Models\GenericName;
use App\Models\Product;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface GenericNameRepositoryInterface extends BaseRepositoryInterface
{
    public function createGenericName(array $data): GenericName;

    public function findGenericNameById(int $id): GenericName;

    public function updateGenericName(array $data): bool;

    public function deleteGenericName(): bool;

    public function listGenericNames($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    public function saveProduct(Product $product);

    public function searchGenericName(string $text): Collection;
}
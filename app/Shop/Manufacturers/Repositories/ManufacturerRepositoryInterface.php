<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/22/18
 * Time: 6:02 PM
 */

namespace App\Shop\Manufacturers\Repositories;


use App\Models\Manufacturer;
use App\Models\Product;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface ManufacturerRepositoryInterface extends BaseRepositoryInterface
{
    public function createManufacturer(array $data): Manufacturer;

    public function findManufacturerById(int $id): Manufacturer;

    public function updateManufacturer(array $data): bool;

    public function deleteManufacturer(): bool;

    public function listManufacturers($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    public function saveProduct(Product $product);

    public function searchManufacturer(string $text): Collection;
}
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
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;


interface PackSizeRepositoryInterface extends BaseRepositoryInterface
{
    public function createPackSize(array $data): PackSize;

    public function findPackSizeById(int $id): PackSize;

    public function updatePackSize(array $data): bool;

    public function deletePackSize(): ?bool;

    public function listPackSizes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    public function listPackSizeValues(): Collection;

    public function associatePackSizeValue(PackSizeValue $attributeValue): PackSizeValue;
}

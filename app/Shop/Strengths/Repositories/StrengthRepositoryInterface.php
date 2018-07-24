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
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface StrengthRepositoryInterface extends BaseRepositoryInterface
{
    public function createStrength(array $data): Strength;

    public function findStrengthById(int $id): Strength;

    public function updateStrength(array $data): bool;

    public function deleteStrength(): bool;

    public function listStrengths($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    public function saveProduct(Product $product);

    public function searchStrength(string $text): Collection;
}
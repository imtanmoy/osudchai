<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/25/18
 * Time: 11:10 AM
 */

namespace App\Shop\Attributes\Repositories;


use App\Models\Attribute;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface AttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function createAttribute(array $data): Attribute;

    public function findAttributeById(int $id): Attribute;

    public function updateAttribute(array $data): bool;

    public function deleteAttribute(): ?bool;

    public function listAttributes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    public function searchAttribute(string $text): Collection;

//    public function listAttributeValues(): Collection;

//    public function associateAttributeValue(AttributeValue $attributeValue): AttributeValue;
}
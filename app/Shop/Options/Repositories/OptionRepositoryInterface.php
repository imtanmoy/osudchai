<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:24 AM
 */

namespace App\Shop\Options\Repositories;


use App\Models\Option;
use App\Models\OptionValue;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface OptionRepositoryInterface extends BaseRepositoryInterface
{
    public function createOption(array $data): Option;

    public function findOptionById(int $id): Option;

    public function updateOption(array $data): bool;

    public function deleteOption(): ?bool;

    public function listOptions($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    public function listOptionValues(): Collection;

    public function associateOptionValue(OptionValue $optionValue): OptionValue;
}
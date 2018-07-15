<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:38 AM
 */

namespace App\Shop\OptionValues\Repositories;


use App\Models\Option;
use App\Models\OptionValue;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface OptionValueRepositoryInterface extends BaseRepositoryInterface
{
    public function createOptionValue(Option $option, array $data): OptionValue;

    public function associateToOption(Option $option): OptionValue;

    public function dissociateFromOption(): bool;

    public function findProductOptions(): Collection;
}
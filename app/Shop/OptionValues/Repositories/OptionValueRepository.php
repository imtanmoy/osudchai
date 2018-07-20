<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:39 AM
 */

namespace App\Shop\OptionValues\Repositories;


use App\Models\Option;
use App\Models\OptionValue;
use App\Shop\Base\BaseRepository;
use Illuminate\Support\Collection;

class OptionValueRepository extends BaseRepository implements OptionValueRepositoryInterface
{

    /**
     * @var $model
     */
    protected $model;


    /**
     * PackSizeValueRepository constructor.
     * @param OptionValue $optionValue
     */
    public function __construct(OptionValue $optionValue)
    {
        parent::__construct($optionValue);
        $this->model = $optionValue;
    }

    /**
     * @param Option $option
     * @param array $data
     * @return OptionValue
     */
    public function createOptionValue(Option $option, array $data): OptionValue
    {
        $optionValue = new OptionValue($data);
        $optionValue->option()->associate($option);
        $optionValue->save();
        return $optionValue;
    }

    public function associateToOption(Option $option): OptionValue
    {
        $this->model->option()->associate($option);
        $this->model->save();
        return $this->model;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function dissociateFromOption(): bool
    {
        return $this->model->option()->delete();
    }

    /**
     * @return Collection
     */
    public function findProductOptions(): Collection
    {
        return $this->model->productOptions()->get();
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:26 AM
 */

namespace App\Shop\Options\Repositories;


use App\Models\Option;
use App\Models\OptionValue;
use App\Shop\Base\BaseRepository;
use App\Shop\Options\Exceptions\CreateOptionErrorException;
use App\Shop\Options\Exceptions\OptionNotFoundException;
use App\Shop\Options\Exceptions\UpdateOptionErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class OptionRepository extends BaseRepository implements OptionRepositoryInterface
{

    protected $model;

    /**
     * OptionRepository constructor.
     * @param Option $option
     */
    public function __construct(Option $option)
    {
        parent::__construct($option);
        $this->model = $option;
    }


    /**
     * @param array $data
     * @return Option
     * @throws CreateOptionErrorException
     */
    public function createOption(array $data): Option
    {
        try {
            $option = new Option($data);
            $option->save();
            return $option;
        } catch (QueryException $e) {
            throw new CreateOptionErrorException($e);
        }
    }

    /**
     * @param int $id
     * @return Option
     * @throws OptionNotFoundException
     */
    public function findOptionById(int $id): Option
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new OptionNotFoundException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdateOptionErrorException
     */
    public function updateOption(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateOptionErrorException($e);
        }
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function deleteOption(): ?bool
    {
        return $this->model->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function listOptions($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @return Collection
     */
    public function listOptionValues(): Collection
    {
        return $this->model->values()->get();
    }

    /**
     * @param OptionValue $optionValue
     * @return OptionValue|false
     */
    public function associateOptionValue(OptionValue $optionValue): OptionValue
    {
        return $this->model->values()->save($optionValue);
    }
}
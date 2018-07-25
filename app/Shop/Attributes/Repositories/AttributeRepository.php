<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/25/18
 * Time: 11:11 AM
 */

namespace App\Shop\Attributes\Repositories;


use App\Models\Attribute;
use App\Shop\Attributes\Exceptions\AttributeNotFoundErrorException;
use App\Shop\Attributes\Exceptions\CreateAttributeErrorException;
use App\Shop\Attributes\Exceptions\UpdateAttributeErrorException;
use App\Shop\Base\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{

    protected $model;

    /**
     * AttributeRepository constructor.
     * @param Attribute $attribute
     */
    public function __construct(Attribute $attribute)
    {
        parent::__construct($attribute);
        $this->model = $attribute;
    }

    /**
     * @param array $data
     * @return Attribute
     * @throws CreateAttributeErrorException
     */
    public function createAttribute(array $data): Attribute
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateAttributeErrorException($e);
        }
    }

    /**
     * @param int $id
     * @return Attribute
     * @throws AttributeNotFoundErrorException
     */
    public function findAttributeById(int $id): Attribute
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new AttributeNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws UpdateAttributeErrorException
     */
    public function updateAttribute(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateAttributeErrorException($e);
        }
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function deleteAttribute(): ?bool
    {
        return $this->model->delete();
    }

    public function listAttributes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function searchAttribute(string $text): Collection
    {
        return $this->model->search($text, [
            'name' => 10
        ])->get();
    }
}
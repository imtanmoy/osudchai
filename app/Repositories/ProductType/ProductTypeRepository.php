<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 1/8/2018
 * Time: 12:19 AM
 */

namespace App\Repositories\ProductType;

use App\Models\ProductType;

class ProductTypeRepository implements ProductTypeInterface
{
    private $model;

    /**
     * ProductTypeRepository constructor.
     * @param $model
     */
    public function __construct(ProductType $model)
    {
        $this->model = $model;
    }


    function getAll()
    {
        return $this->model->all();
    }

    function getById($id)
    {
        return $this->model->find($id);
    }

    function create(array $attributes)
    {
        try {
            return $this->model->create($attributes);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }

    function update($id, array $attributes)
    {
        try {
            return $this->model->find($id)->update($attributes);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    function delete($id)
    {
        try {
            return $this->model->find($id)->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

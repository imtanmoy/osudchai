<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 1/14/2018
 * Time: 12:02 PM
 */

namespace App\Repositories\Attribute;


use App\Models\Attribute;

class AttributeRepository implements AttributeInterface
{
    protected $attribute;

    /**
     * AttributeRepository constructor.
     * @param $attribute
     */
    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }


    function getAll()
    {
        return $this->attribute->all();
    }

    function getById($id)
    {
        return $this->attribute->find($id);
    }

    function create(array $attributes)
    {
        try {
            return $this->attribute->create($attributes);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    function update($id, array $attributes)
    {
        try {
            return $this->attribute->find($id)->update($attributes);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }

    }

    function delete($id)
    {
        try {
            return $this->attribute->find($id)->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
}

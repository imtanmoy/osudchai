<?php

namespace App\Repositories\ProductType;


interface ProductTypeInterface
{
    function getAll();

    function getById($id);

    function create(array $attributes);

    function update($id, array $attributes);

    function delete($id);
}

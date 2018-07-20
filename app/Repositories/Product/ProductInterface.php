<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 1/14/2018
 * Time: 5:21 PM
 */

namespace App\Repositories\Product;


use App\Models\Product;

interface ProductInterface
{
    function getAll();

    function getById($id): Product;

    function create(array $attributes);

    function update($id, array $attributes);

    function delete($id);
}

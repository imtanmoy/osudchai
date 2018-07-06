<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 1/14/2018
 * Time: 12:01 PM
 */

namespace App\Repositories\Attribute;


interface AttributeInterface
{
    function getAll();

    function getById($id);

    function create(array $attributes);

    function update($id, array $attributes);

    function delete($id);
}
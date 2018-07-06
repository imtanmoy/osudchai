<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 1/8/2018
 * Time: 3:21 PM
 */

namespace App\Repositories\Categories;


interface CategoryInterface
{
    function getAll();

    function getById($id);

    function create(array $attributes);

    function update($id, array $attributes);

    function delete($id);

    function getSubCategories($id);

    function createSubCategory(array $attributes);

    function updateSubCategory($id, array $attributes);

    function deleteSubCategory($id, $sid);

    function createSubSubCategory(array $attributes);
}
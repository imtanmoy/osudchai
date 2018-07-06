<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 1/8/2018
 * Time: 3:22 PM
 */

namespace App\Repositories\Categories;


use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;


class CategoryRepository implements CategoryInterface
{

    protected $category;

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    function getAll()
    {
        $all_parent_categories = $this->category->where('parent_id', '=', 0)->get();

        $final_categories = [];

        foreach ($all_parent_categories as $category) {
//            $final_categories['category'] = $category;
//            echo '<br>';
//            print_r($final_categories);
//            echo $final_categories;
//            $final_categories['subCategories'] = $this->category->where('parent_id', '=', $category->id)->get();
            $parent_category = $category;
            $parent_category->subCategories = $this->category->where('parent_id', '=', $category->id)->get();
            array_push($final_categories, $parent_category);
        }


//        dd($final_categories);
        return $final_categories;
    }

    function getById($id)
    {
//        dd($id);
        return $this->category->find($id);
//        $category = DB::table('categories')->where('id', $id)->first();
//        dd($category);
//        $subCategoriesCount = DB::table('categories')->where('parent_id', '=', $category->id)->count();
//        if ($subCategoriesCount > 0) {
////            print_r(count($subCategories));
///
//        $subCategories = DB::table('categories')->where('parent_id', '=', $category->id)->get();
//dd($subCategories);
//        $category->subCategories = $subCategories;
//        }else
//        {
//            $category->subCategories = [];
//        }
//        dd($category);

//        return $category;
    }

    function create(array $attributes)
    {
////        dd($attributes);
//        $subCategories = [];
//        if (!empty($attributes['subCategoryNames'])) {
//            $subCategories = explode(',', $attributes['subCategoryNames']);
//        }
////        dd($subCategories, $attributes);
//        if (isset($attributes['name'])) {
////            dd($attributes['name']);
//            $new_category = $this->category->create($attributes);
////            dd($new_category->id);
//            $new_subCategory = [];
//            if (count($subCategories) > 0) {
//                $i = 1;
//                foreach ($subCategories as $value) {
//                    $new_subCategory['name'] = $value;
//                    $this->category->create(['name' => $value, 'weight' => $i, 'parent_id' => $new_category->id]);
//                    $i++;
//                }
//            }
//            return $new_category;
//        }

    }

    function update($id, array $attributes)
    {
        $subCategories = [];
        if (!empty($attributes['subCategories'])) {
            $subCategories = explode(',', $attributes['subCategories']);
        }
        if (isset($attributes['name'])) {
            $category = $this->category->find($id)->update($attributes);
            $subCategoriesCount = DB::table('categories')->where('parent_id', '=', $id)->count();
            return $category;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    function delete($id)
    {
//        $del_category = $this->category->find($id);
//        $this->category->where('parent_id', '=', $del_category->id)->delete();
//        return $del_category->delete();
//        DB::table("categories")->whereIn('id',e,$ids))->delete();
//        dd($del_category, $subCategories);
//        return $this->category->find($id)->delete();
        $category = DB::table('categories')->where('id', $id)->first();
        $subCategoriesCount = DB::table('categories')->where('parent_id', '=', $category->id)->count();
        if ($subCategoriesCount > 0) {
//            print_r(count($subCategories));
            DB::table('categories')->where('parent_id', '=', $category->id)->delete();
        }
//        dd(count($subCategories));
//        DB::table('categories')->where('parent_id', '=', $category->id)->delete();
        DB::table('categories')->where('id', '=', $category->id)->delete();
        return $category;
    }


    function getSubCategories($id)
    {
        if (isset($id)) {
            return DB::table('categories')->where('id', '=', $id)->get();
        } else {
            return [];
        }
    }

    function deleteSubCategory($id, $sid)
    {
        if (isset($id)) {
            DB::table('categories')->where('id', '=', $sid)->delete();
            return true;
        } else {
            return false;
        }

    }

    function createSubCategory(array $attributes)
    {

        if (isset($attributes['category_id']) && isset($attributes['name'])) {
            $weight = 1;
            if (isset($attributes['weight'])) {
                $weight = $attributes['weight'];
            }
            return $this->category->create(['name' => $attributes['name'], 'weight' => $weight, 'parent_id' => $attributes['category_id']]);
        } else {
            return false;
        }

//        $res = DB::table('categories')->insert(
//            ['name' => $attributes['name'], 'parent_id' => $id]
//        );
//        return $res;
    }

    function updateSubCategory($id, array $attributes)
    {
        $res = DB::table('categories')
            ->where('id', $id)
            ->update(['name' => $attributes['name'], 'weight' => $attributes['weight']]);
        return $res;
    }


    function createSubSubCategory(array $attributes)
    {
//        dd($attributes);
        if (isset($attributes['category_id']) && isset($attributes['subCategory_id']) && isset($attributes['name'])) {
            $weight = 1;
            if (isset($attributes['weight'])) {
                $weight = $attributes['weight'];
            }
            return $this->category->create(['name' => $attributes['name'], 'weight' => $weight, 'parent_id' => $attributes['subCategory_id']]);
        } else {
            return false;
        }
    }
}
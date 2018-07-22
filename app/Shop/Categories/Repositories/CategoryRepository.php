<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/22/18
 * Time: 6:45 PM
 */

namespace App\Shop\Categories\Repositories;


use App\Models\Category;
use App\Models\Product;
use App\Shop\Base\BaseRepository;
use App\Shop\Categories\Exceptions\CategoryInvalidArgumentException;
use App\Shop\Categories\Exceptions\CategoryNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    protected $model;

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->model = $category;
    }


    public function listCategories(string $order = 'id', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @param array $params
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function createCategory(array $params): Category
    {
        try {
            $collection = collect($params);
            if (isset($params['name'])) {
                $slug = str_slug($params['name']);
            }

            $merge = $collection->merge(compact('slug'));
            $category = new Category($merge->except('parent_id'));
            if (isset($params['parent_id'])) {
                $parent = $this->findCategoryById($params['parent_id']);
                $category->parent()->associate($parent);
            }
            $category->save();
            return $category;
        } catch (QueryException $e) {
            throw new CategoryInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function updateCategory(array $params): Category
    {
        $category = $this->findCategoryById($this->model->id);
        $collection = collect($params)->except('_token', 'parent_id');
        $slug = str_slug($collection->get('name'));
        $merge = $collection->merge(compact('slug'));
        if (isset($params['parent_id'])) {
            $parent = $this->findCategoryById($params['parent_id']);
            $category->parent()->associate($parent);
        }
        $category->update($merge->all());
        return $category;
    }

    /**
     * @param int $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryById(int $id): Category
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e->getMessage());
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCategory(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param Product $product
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function associateProduct(Product $product)
    {
        return $this->model->products()->save($product);
    }

    public function findProducts(): Collection
    {
        return $this->model->products;
    }

    public function syncProducts(array $params)
    {
//        $this->model->products()->sync($params);
    }

    public function detachProducts()
    {
        // TODO: Implement detachProducts() method.
    }

    public function deleteFile(array $file, $disk = null): bool
    {
        // TODO: Implement deleteFile() method.
    }

    /**
     * @param array $slug
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryBySlug(array $slug): Category
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }

    /**
     * @return mixed
     */
    public function findParentCategory()
    {
        return $this->model->parent;
    }

    /**
     * @return mixed
     */
    public function findChildren()
    {
        return $this->model->children;
    }
}
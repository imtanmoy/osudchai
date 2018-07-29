<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/22/18
 * Time: 6:44 PM
 */

namespace App\Shop\Categories\Repositories;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function listCategories(string $order = 'id', string $sort = 'desc', $except = []): Collection;

    public function createCategory(array $params): Category;

    public function updateCategory(array $params): Category;

    public function findCategoryById(int $id): Category;

    public function deleteCategory(): bool;

    public function associateProduct(Product $product);

    public function findProducts(): Collection;

    public function syncProducts(array $params);

    public function detachProducts();

    public function deleteFile(array $file, $disk = null): bool;

    public function findCategoryBySlug(array $slug): Category;
}
<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/1/18
 * Time: 1:10 PM
 */

namespace App\Shop\Products\Repositories;


use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function listProducts(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection;

    public function createProduct(array $data): Product;

    public function updateProduct(array $data): bool;

    public function findProductById(int $id): Product;

    public function deleteProduct(Product $product): bool;

    public function removeProduct(): bool;

    public function dissociateCategory();

    public function getCategory(): Category;

    public function associateCategory(Category $category);

    public function deleteFile(array $file, $disk = null): bool;

    public function deleteThumb(string $src): bool;

    public function findProductBySlug(array $slug): Product;

    public function searchProduct(string $text): Collection;

    public function findProductImages(): Collection;

    public function saveCoverImage(UploadedFile $file): string;

    public function saveProductImages(Collection $collection);

    public function saveManufacturer(Manufacturer $manufacturer);

    public function findManufacturer();
}
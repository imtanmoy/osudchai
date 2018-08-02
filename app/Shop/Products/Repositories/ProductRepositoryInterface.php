<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/1/18
 * Time: 1:10 PM
 */

namespace App\Shop\Products\Repositories;


use App\Models\Category;
use App\Models\GenericName;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductType;
use App\Models\Strength;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
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

    public function saveCoverImage(UploadedFile $file);

    public function saveProductImages(Collection $collection);

    public function associateManufacturer(Manufacturer $manufacturer);

    public function dissociateManufacturer();

    public function findManufacturer();

    public function associateGenericName(GenericName $genericName);

    public function dissociateGenericName();

    public function findGenericName();

    public function associateStrength(Strength $strength);

    public function dissociateStrength();

    public function findStrength();

    public function associateProductType(ProductType $productType);

    public function dissociateProductType();

    public function findProductType();

    public function saveProductStock(ProductStock $productStock);

    public function deleteProductStock(): bool;

    public function getProductStock(): ProductStock;
}

<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/1/18
 * Time: 1:14 PM
 */

namespace App\Shop\Products\Repositories;


use App\Models\Category;
use App\Models\GenericName;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductOption;
use App\Models\ProductStock;
use App\Models\ProductType;
use App\Models\Strength;
use App\Shop\Base\BaseRepository;
use App\Shop\Products\Exceptions\ProductCreateErrorException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Exceptions\ProductUpdateErrorException;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    use ProductTransformable, UploadableTrait;

    protected $model;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->model = $product;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listProducts(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param array $data
     * @return Product
     * @throws ProductCreateErrorException
     */
    public function createProduct(array $data): Product
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new ProductCreateErrorException($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws ProductUpdateErrorException
     */
    public function updateProduct(array $data): bool
    {
        $filtered = collect($data)->except('image')->all();
        try {
            return $this->model->where('id', $this->model->id)->update($filtered);
        } catch (QueryException $e) {
            throw new ProductUpdateErrorException($e);
        }
    }

    /**
     * @param int $id
     * @return Product
     * @throws ProductNotFoundException
     */
    public function findProductById(int $id): Product
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProductNotFoundException($e);
        }
    }

    /**
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function deleteProduct(Product $product): bool
    {
        $product->images()->delete();
        return $product->delete();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function removeProduct(): bool
    {
        return $this->model->where('id', $this->model->id)->delete();
    }

    /**
     *
     */
    public function dissociateCategory()
    {
        $this->model->category()->dissociate()->save();
    }

    public function getCategory(): Category
    {
        return $this->model->category;
    }

    public function associateCategory(Category $category)
    {
        $this->model->category()->associate($category)->save();
    }

    public function deleteFile(array $file, $disk = null): bool
    {
        // TODO: Implement deleteFile() method.
    }

    public function deleteThumb(string $src): bool
    {
        return DB::table('product_images')->where('src', $src)->delete();
    }

    /**
     * @param array $slug
     * @return Product
     * @throws ProductNotFoundException
     */
    public function findProductBySlug(array $slug): Product
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new ProductNotFoundException($e);
        }
    }

    public function searchProduct(string $text): Collection
    {
        if (!empty($text)) {
            return $this->model->searchProduct($text);
        } else {
            return $this->listProducts();
        }
    }

    public function findProductImages(): Collection
    {
        return $this->model->images()->get();
    }

    public function saveCoverImage(UploadedFile $file)
    {
        $filename = $this->storeFile($file);
        $productImage = new ProductImage([
            'product_id' => $this->model->id,
            'name' => $filename,
            'src' => $filename,
            'cover' => 1
        ]);
        $this->model->images()->save($productImage);
    }

    public function saveProductImages(Collection $collection)
    {
        $collection->each(function (UploadedFile $file) {
            $filename = $this->storeFile($file);
            $productImage = new ProductImage([
                'product_id' => $this->model->id,
                'name' => $filename,
                'src' => $filename
            ]);
            $this->model->images()->save($productImage);
        });
    }

    public function associateManufacturer(Manufacturer $manufacturer)
    {
        $this->model->manufacturer()->associate($manufacturer)->save();
    }

    public function findManufacturer()
    {
        return $this->model->manufacturer;
    }

    public function dissociateManufacturer()
    {
        $this->model->manufacturer()->dissociate()->save();
    }

    public function associateGenericName(GenericName $genericName)
    {
        $this->model->generic_name()->associate($genericName)->save();
    }

    public function dissociateGenericName()
    {
        $this->model->generic_name()->dissociate()->save();
    }

    public function findGenericName()
    {
        return $this->model->generic_name;
    }

    public function associateStrength(Strength $strength)
    {
        $this->model->strength()->associate($strength)->save();
    }

    public function dissociateStrength()
    {
        $this->model->strength()->dissociate()->save();
    }

    public function findStrength()
    {
        return $this->model->strength;
    }

    public function associateProductType(ProductType $productType)
    {
        $this->model->product_type()->associate($productType)->save();
    }

    public function dissociateProductType()
    {
        $this->model->product_type()->dissociate()->save();
    }

    public function findProductType()
    {
        return $this->model->product_type;
    }

    /**
     * @param ProductStock $productStock
     * @return void
     */
    public function saveProductStock(ProductStock $productStock)
    {
        $this->model->stock()->save($productStock);
    }

    public function deleteProductStock(): bool
    {
        return $this->model->stock()->delete();
    }

    public function getProductStock(): ProductStock
    {
        return $this->model->stock;
    }

    /**
     * @param ProductAttribute $productAttribute
     * @return void
     */
    public function saveProductAttribute(ProductAttribute $productAttribute)
    {
        $this->model->attributes()->save($productAttribute);
    }

    /**
     * @param ProductAttribute $productAttribute
     * @return bool
     * @throws \Exception
     */
    public function removeProductAttribute(ProductAttribute $productAttribute): bool
    {
        return $productAttribute->delete();
    }

    public function saveProductOption(ProductOption $productOption): ProductOption
    {
        $this->model->options()->save($productOption);
        return $productOption;
    }

    public function updateProductStock(array $params)
    {
        $this->model->stock()->update($params);
    }
}

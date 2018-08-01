<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/1/18
 * Time: 1:14 PM
 */

namespace App\Shop\Products\Repositories;


use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Shop\Base\BaseRepository;
use App\Shop\Products\Exceptions\ProductCreateErrorException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Exceptions\ProductUpdateErrorException;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use DB;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Storage;

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
            return $this->transformProduct($this->findOneOrFail($id));
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
        $this->model->category()->dissociate();
    }

    public function getCategory(): Category
    {
        return $this->model->category;
    }

    public function associateCategory(Category $category)
    {
        $this->model->category()->associate($category);
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

    public function saveCoverImage(UploadedFile $file): string
    {
        $fileName = trim(time() . $file->getClientOriginalName());
        return $file->storeAs('products', $fileName, ['disk' => 'public']);
    }

    public function saveProductImages(Collection $collection)
    {
        $collection->each(/**
         * @param UploadedFile $file
         */
            function (UploadedFile $file) {
                $filename = $this->storeFile($file);
                $productImage = new ProductImage([
                    'product_id' => $this->model->id,
                    'src' => $filename
                ]);
                $this->model->images()->save($productImage);
            });
    }

    public function saveManufacturer(Manufacturer $manufacturer)
    {
        $this->model->manufacturer()->associate($manufacturer);
    }

    public function findManufacturer()
    {
        return $this->model->manufacturer;
    }
}
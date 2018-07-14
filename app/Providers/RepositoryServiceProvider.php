<?php

namespace App\Providers;

use App\Repositories\Attribute\AttributeInterface;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductType\ProductTypeInterface;
use App\Repositories\ProductType\ProductTypeRepository;
use App\Shop\PackSize\Repositories\PackSizeRepository;
use App\Shop\PackSize\Repositories\PackSizeRepositoryInterface;
use App\Shop\PackSizeValues\Repositories\PackSizeValueRepository;
use App\Shop\PackSizeValues\Repositories\PackSizeValueRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductTypeInterface::class, ProductTypeRepository::class);
        $this->app->bind(AttributeInterface::class, AttributeRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(
            PackSizeRepositoryInterface::class,
            PackSizeRepository::class
        );
        $this->app->bind(
            PackSizeValueRepositoryInterface::class,
            PackSizeValueRepository::class
        );
    }
}

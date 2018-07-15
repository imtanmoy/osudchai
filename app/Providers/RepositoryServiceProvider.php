<?php

namespace App\Providers;

use App\Repositories\Attribute\AttributeInterface;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductType\ProductTypeInterface;
use App\Repositories\ProductType\ProductTypeRepository;
use App\Shop\Options\Repositories\OptionRepository;
use App\Shop\Options\Repositories\OptionRepositoryInterface;
use App\Shop\OptionValues\Repositories\OptionValueRepository;
use App\Shop\OptionValues\Repositories\OptionValueRepositoryInterface;
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
            OptionRepositoryInterface::class,
            OptionRepository::class
        );
        $this->app->bind(
            OptionValueRepositoryInterface::class,
            OptionValueRepository::class
        );
    }
}

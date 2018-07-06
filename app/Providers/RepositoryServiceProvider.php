<?php

namespace App\Providers;

use App\Repositories\Attribute\AttributeInterface;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\ProductType\ProductTypeInterface;
use App\Repositories\ProductType\ProductTypeRepository;
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
    }
}

<?php

namespace App\Providers;

use App\Repositories\Attribute\AttributeInterface;
use App\Repositories\Attribute\AttributeRepository;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\AddressRepositoryInterface;
use App\Shop\GenericNames\Repositories\GenericNameRepository;
use App\Shop\GenericNames\Repositories\GenericNameRepositoryInterface;
use App\Shop\Manufacturers\Repositories\ManufacturerRepository;
use App\Shop\Manufacturers\Repositories\ManufacturerRepositoryInterface;
use App\Shop\Options\Repositories\OptionRepository;
use App\Shop\Options\Repositories\OptionRepositoryInterface;
use App\Shop\OptionValues\Repositories\OptionValueRepository;
use App\Shop\OptionValues\Repositories\OptionValueRepositoryInterface;
use App\Shop\OrderItems\Repositories\OrderItemRepository;
use App\Shop\OrderItems\Repositories\OrderItemRepositoryInterface;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Orders\Repositories\OrderRepositoryInterface;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepositoryInterface;
use App\Shop\PaymentMethods\Repositories\PaymentMethodRepository;
use App\Shop\PaymentMethods\Repositories\PaymentMethodRepositoryInterface;
use App\Shop\ProductTypes\Repositories\ProductTypeRepository;
use App\Shop\ProductTypes\Repositories\ProductTypeRepositoryInterface;
use App\Shop\Strengths\Repositories\StrengthRepository;
use App\Shop\Strengths\Repositories\StrengthRepositoryInterface;
use App\Shop\Users\Repositories\UserRepository;
use App\Shop\Users\Repositories\UserRepositoryInterface;
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
        $this->app->bind(
            AttributeInterface::class,
            AttributeRepository::class
        );
        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            OptionRepositoryInterface::class,
            OptionRepository::class
        );
        $this->app->bind(
            OptionValueRepositoryInterface::class,
            OptionValueRepository::class
        );
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->bind(
            AddressRepositoryInterface::class,
            AddressRepository::class
        );
        $this->app->bind(
            PaymentMethodRepositoryInterface::class,
            PaymentMethodRepository::class
        );
        $this->app->bind(
            OrderItemRepositoryInterface::class,
            OrderItemRepository::class
        );
        $this->app->bind(
            OrderStatusRepositoryInterface::class,
            OrderStatusRepository::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            ManufacturerRepositoryInterface::class,
            ManufacturerRepository::class
        );
        $this->app->bind(
            GenericNameRepositoryInterface::class,
            GenericNameRepository::class
        );
        $this->app->bind(
            StrengthRepositoryInterface::class,
            StrengthRepository::class
        );
        $this->app->bind(
            ProductTypeRepositoryInterface::class,
            ProductTypeRepository::class
        );
    }
}

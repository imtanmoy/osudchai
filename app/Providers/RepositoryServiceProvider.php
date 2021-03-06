<?php

namespace App\Providers;

use App\Shop\AccountKits\Repositories\AccountKitRepository;
use App\Shop\AccountKits\Repositories\AccountKitRepositoryInterface;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\AddressRepositoryInterface;
use App\Shop\Attributes\Repositories\AttributeRepository;
use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\CategoryRepositoryInterface;
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
use App\Shop\Prescriptions\Repositories\PrescriptionRepository;
use App\Shop\Prescriptions\Repositories\PrescriptionRepositoryInterface;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepository;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Repositories\ProductRepositoryInterface;
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
            AttributeRepositoryInterface::class,
            AttributeRepository::class
        );
        $this->app->bind(
            ProductTypeRepositoryInterface::class,
            ProductTypeRepository::class
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
        $this->app->bind(
            AccountKitRepositoryInterface::class,
            AccountKitRepository::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            ProductAttributeRepositoryInterface::class,
            ProductAttributeRepository::class
        );
        $this->app->bind(
            PrescriptionRepositoryInterface::class,
            PrescriptionRepository::class
        );
    }
}

<?php

namespace App\Providers;

use App\Repositories\Contracts\CustomerInterface;
use App\Repositories\Contracts\InventoryInterface;
use App\Repositories\Contracts\ProductInterface;
use App\Repositories\Contracts\SalesOrderInterface;
use App\Repositories\Contracts\SalesOrderLineInterface;
use App\Repositories\Contracts\UserInterface;
use App\Repositories\Contracts\WarehouseInterface;
use App\Repositories\Implementations\CustomerRepository;
use App\Repositories\Implementations\InventoryRepository;
use App\Repositories\Implementations\ProductRepository;
use App\Repositories\Implementations\SalesOrderLineRepository;
use App\Repositories\Implementations\SalesOrderRepository;
use App\Repositories\Implementations\UserRepository;
use App\Repositories\Implementations\WarehouseRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(SalesOrderInterface::class, SalesOrderRepository::class);
        $this->app->bind(SalesOrderLineInterface::class, SalesOrderLineRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(InventoryInterface::class, InventoryRepository::class);
        $this->app->bind(WarehouseInterface::class, WarehouseRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

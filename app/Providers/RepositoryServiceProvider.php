<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Contracts\MenuRepository::class, \App\Repositories\Eloquent\MenuRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\MerchantRepository::class, \App\Repositories\Eloquent\MerchantRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\PublicRepository::class, \App\Repositories\Eloquent\PublicRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\MerchantAdminRepository::class, \App\Repositories\Eloquent\MerchantAdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\MerchantRoleRepository::class, \App\Repositories\Eloquent\MerchantRoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\ShopRepository::class, \App\Repositories\Eloquent\ShopRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\MerchantPermissionRepository::class, \App\Repositories\Eloquent\MerchantPermissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\WaiterLevelRepository::class, \App\Repositories\Eloquent\WaiterLevelRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\WaiterRepository::class, \App\Repositories\Eloquent\WaiterRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\GoodsCateRepository::class, \App\Repositories\Eloquent\GoodsCateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\WaiterAlbumRepository::class, \App\Repositories\Eloquent\WaiterAlbumRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\AppointRankRepository::class, \App\Repositories\Eloquent\AppointRankRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\AppointRepository::class, \App\Repositories\Eloquent\AppointRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\MemberRepository::class, \App\Repositories\Eloquent\MemberRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\WaiterCommentRepository::class, \App\Repositories\Eloquent\WaiterCommentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\MerchantAddressRepository::class, \App\Repositories\Eloquent\MerchantAddressRepositoryEloquent::class);

        //:end-bindings:
    }
}

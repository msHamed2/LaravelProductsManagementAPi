<?php

namespace App\Providers;

use App\Models\Products;
use App\Policies\ProductsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Products::class => ProductsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('canStore', [ProductsPolicy::class, 'create']);
        Gate::define('canUpdate', [ProductsPolicy::class, 'update']);
        Gate::define('canDelete', [ProductsPolicy::class, 'delete']);

        //
    }
}

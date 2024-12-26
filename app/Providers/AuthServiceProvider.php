<?php

namespace App\Providers;

use App\Models\Listing;
use App\Policies\ListingsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider{
    protected $policies = [
        Listing::class => ListingsPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}

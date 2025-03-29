<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Register middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('premium', \App\Http\Middleware\RequirePremium::class);

        // Add Blade directives for premium
        Blade::directive('premium', function () {
            return "<?php if (auth()->check() && auth()->user()->isPremium()): ?>";
        });

        Blade::directive('endpremium', function () {
            return "<?php endif; ?>";
        });
    }
}

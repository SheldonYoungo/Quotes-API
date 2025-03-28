<?php

namespace QuotesApiPackage\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use QuotesApiPackage\Services\QuoteService;

class QuoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerRoutes();

        $this->publishAssets();

        $this->app->singleton(QuoteService::class, function ($app) {
            return new QuoteService();
        });

        $this->mergeConfigFrom(__DIR__.'/../../config/quotes.php', 'quotes');
        $this->mergeConfigFrom(__DIR__.'/../../config/cache.php', 'cache');
        // $this->mergeConfigFrom(__DIR__.'/../../config/vite.php', 'vite');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'quotes-api-package');
        $this->publishConfig();
        // Limitar peticiones a la API
        RateLimiter::for('api', function ($request) {
            return Limit::perMinutes(
                config('quotes.windowTime') / 60, 
                config('quotes.limitRequest')     
            )->by(optional($request->user())->id ?: $request->ip());
        });

    }


    /**
     * Registrar las rutas del paquete.
     *
     * @return void
     */
    public function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Publicar activos del paquete.
     *
     * @return void
     */
    protected function publishAssets()
    {
        $this->publishes([
            __DIR__.'/../../public/build' => public_path('vendor/quotes-api-package/build'),
            // __DIR__.'/../resources/views' => resource_path('views/vendor/quotes-api-package'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../resources/css' => resource_path('vendor/quotes-api-package/css'),
            __DIR__.'/../resources/js' => resource_path('vendor/quotes-api-package/js'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/quotes-api-package'),
        ], 'views');
    }

    /**
     * Publicar activos del paquete.
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/quotes.php' => public_path('/../config/quotes.php'),
            __DIR__.'/../../config/cache.php' => public_path('/../config/cache.php'),
            // __DIR__.'/../../config/vite.php' => public_path('/../config/vite.php'),
        ], 'quotes-config');
    }
}

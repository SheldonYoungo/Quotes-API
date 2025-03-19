<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registrar rutas
        $this->registerRoutes();

        // Registrar vistas
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'mi_paquete');

        // Publicar activos
        $this->publishAssets();

        $this->app->singleton(\App\Services\QuoteService::class, function ($app) {
            return new \App\Services\QuoteService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
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
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }

    /**
     * Publicar activos del paquete.
     *
     * @return void
     */
    protected function publishAssets()
    {
        $this->publishes([
            __DIR__.'/../../public' => public_path('vendor/quotes-api'),
        ], 'public');
    }
}

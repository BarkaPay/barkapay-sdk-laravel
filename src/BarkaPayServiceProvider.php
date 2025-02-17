<?php

namespace BarkapayLaravel;

use Illuminate\Support\ServiceProvider;
use BarkapayLaravel\Services\BaseBarkaPayPaymentService;
use BarkapayLaravel\Services\APIBarkaPayPaymentService;
use BarkapayLaravel\Services\SCIBarkaPayPaymentService;

class BarkaPayServiceProvider extends ServiceProvider
{
    /**
     * Indique que ce provider est différé pour améliorer la performance.
     */
    protected $defer = true;

    /**
     * Register services.
     */
    public function register()
    {
        // Charge la configuration du package
        $this->mergeConfigFrom(__DIR__ . '/Config/barkapay.php', 'barkapay');

        // Liez les services dans le conteneur Laravel
        $this->app->singleton('barkapay.base', function ($app) {
            return new BaseBarkaPayPaymentService();
        });

        $this->app->singleton('barkapay.api', function ($app) {
            return new APIBarkaPayPaymentService();
        });

        $this->app->singleton('barkapay.sci', function ($app) {
            return new SCIBarkaPayPaymentService();
        });

        $this->app->singleton('barkapay', function ($app) {
            return new \BarkapayLaravel\Services\BarkaPayManager(
                $app->make('barkapay.base'),
                $app->make('barkapay.api'),
                $app->make('barkapay.sci')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Publiez le fichier de configuration pour permettre à l'utilisateur de le personnaliser
        $this->publishes([
            __DIR__ . '/Config/barkapay.php' => config_path('barkapay.php'),
        ], 'barkapay-config');
    }

    /**
     * Déclare les services fournis par ce provider (optimisation Laravel).
     */
    public function provides()
    {
        return ['barkapay.base', 'barkapay.api', 'barkapay.sci'];
    }
}

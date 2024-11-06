<?php

namespace BarkapayLaravel;

use Illuminate\Support\ServiceProvider;

class BarkaPayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Charge la configuration du package
        $this->mergeConfigFrom(__DIR__ . '/Config/barkapay.php', 'barkapay');

        // Liez les services dans le conteneur Laravel
        $this->app->singleton('barkapay.base', function ($app) {
            return new Services\BaseBarkaPayPaymentService();
        });

        $this->app->singleton('barkapay.api', function ($app) {
            return new Services\APIBarkaPayPaymentService();
        });

        $this->app->singleton('barkapay.sci', function ($app) {
            return new Services\SCIBarkaPayPaymentService();
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
        ]);
    }
}

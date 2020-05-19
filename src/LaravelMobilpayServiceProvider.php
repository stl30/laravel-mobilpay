<?php

namespace Stl30\LaravelMobilpay;

use App\Observers\TransactionsObserver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class LaravelMobilpayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'laravel-mobilpay');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-mobilpay');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/laravel-mobilpay.php' => config_path('laravel-mobilpay.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/resources/views/laravel-mobilpay' => resource_path('views/vendor/laravel-mobilpay'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/resources/assets' => public_path('vendor/laravel-mobilpay'),
            ], 'assets');

            // Publishing the translation files.
            $this->publishes([
                __DIR__.'/resources/lang' => resource_path('lang/vendor/laravel-mobilpay'),
            ], 'lang');


            // Publishing Observes files.
            //if you want to use observers uncoment below 
//            $this->publishes([
//                __DIR__.'/Observers' => app_path('Observers'),
//            ]);
            
            // Publishing custom classes files.
            $this->publishes([
                __DIR__.'/LaravelMobilpay' => app_path('LaravelMobilpay'),
            ]);

            // Registering package commands.
            // $this->commands([]);
        }
        
//        if you want to use observers uncoment below
//        if(config('laravel-mobilpay.transaction_observer_active')){
//
//            try {
//                if(class_exists('App\Observers\TransactionsObserver')){
//                    MobilpayTransaction::observe(TransactionsObserver::class);
//                }
//                else{
//                    Log::debug(__METHOD__.' Transactions observer does not exist');
//                }
//            } catch (Exception $e) {
//            }
//
//        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/config/laravel-mobilpay.php', 'laravel-mobilpay');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-mobilpay', function () {
            return new LaravelMobilpay;
        });
    }
}

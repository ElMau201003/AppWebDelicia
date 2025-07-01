<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {
        $carrito = session()->get('carrito', []);
        $cantidadTotal = array_sum(array_column($carrito, 'cantidad'));
        $view->with('cantidadCarrito', $cantidadTotal);
      });
    }
}

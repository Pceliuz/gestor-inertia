<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * El path al que los usuarios son redirigidos después del login.
     *
     * En este caso lo dejamos como '/' para evitar conflictos
     * con rutas viejas tipo /dashboard-estudiante.
     */
    public const HOME = '/';

    /**
     * Define las rutas del proyecto.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        // Definición de rutas
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configuración de los límites de solicitudes (rate limiting).
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}

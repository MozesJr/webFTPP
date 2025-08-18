<?php
// bootstrap/app.php (Fixed)

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Add parent routes
            Route::middleware('web')
                ->group(base_path('routes/parent.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register HandleInertiaRequests middleware for web group
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
        ]);

        // FIXED: Merge all middleware aliases in one call
        $middleware->alias([
            'check.role' => CheckRole::class,
            'parent.active' => \App\Http\Middleware\EnsureParentIsActive::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

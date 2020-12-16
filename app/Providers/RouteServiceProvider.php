<?php
declare(strict_types=1);

namespace App\Providers;

use App\Http\Actions;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

final class RouteServiceProvider extends ServiceProvider
{
    protected function loadRoutes(): void
    {
        /** @var Router $router */
        $router = $this->app['router'];
        $router->get('/', Actions\HomeAction::class)->name('home');
    }
}

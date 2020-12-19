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
        $router->group(['middleware' => ['web']], function (Router $router) {
            $router->get('/', Actions\HomeAction::class)->name('home');
            $router->get('/keyword/form', Actions\Keyword\FormAction::class)->name('keyword.form');
            $router->post('/keyword/register', Actions\Keyword\RegisterAction::class)->name('keyword.register');
            $router->get('/keyword/complete', Actions\Keyword\CompleteAction::class)->name('keyword.complete');
            $router->get('/keyword/sorted', Actions\Keyword\ListAction::class)->name('keyword.sorted');
            $router->get('/keyword/suggest', Actions\Keyword\SuggestAction::class)->name('keyword.suggest');
        });
    }
}

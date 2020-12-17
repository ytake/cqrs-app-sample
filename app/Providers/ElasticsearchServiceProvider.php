<?php
declare(strict_types=1);

namespace App\Providers;

use App\Foundation\Elasticsearch\Client;
use App\Foundation\Elasticsearch\ClientFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class ElasticsearchServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(
            Client::class,
            fn(Application $application) => (new ClientFactory())->__invoke($application)
        );
    }

    public function provides(): array
    {
        return [
            Client::class,
        ];
    }
}

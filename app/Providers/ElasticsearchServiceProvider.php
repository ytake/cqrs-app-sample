<?php
declare(strict_types=1);

namespace App\Providers;

use App\DataAccess\Elasticsearch\SortedKeyword;
use App\DataAccess\Elasticsearch\SuggestKeyword;
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
            fn(Application $app) => (new ClientFactory())->__invoke($app)
        );
        $this->app->singleton(
            SortedKeyword::class,
            fn(Application $app) => new SortedKeyword(
                $app->make(\Elasticsearch\Client::class),
                $app['config']['elasticsearch']['keyword_index']
            )
        );
        $this->app->singleton(
            SuggestKeyword::class,
            fn(Application $app) => new SuggestKeyword(
                $app->make(\Elasticsearch\Client::class),
                $app['config']['elasticsearch']['keyword_index']
            )
        );
    }

    public function provides(): array
    {
        return [
            Client::class,
            SortedKeyword::class,
            SuggestKeyword::class,
        ];
    }
}

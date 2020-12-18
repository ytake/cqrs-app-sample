<?php
declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands\KafkaSubscribeCommand;
use App\DataAccess\Database\Keyword;
use App\DataAccess\KeywordProducer;
use App\DataAccess\Repository\KeywordRepositoryByMySql;
use App\Foundation\Elasticsearch\Client;
use App\Listeners\KeywordRegisteredListener;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use SampleDomain\Keyword\Repository\KeywordRepositoryInterface;

final class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
        $this->app->singleton(KafkaSubscribeCommand::class, fn(Application $app) =>
            new KafkaSubscribeCommand()
        );
        $this->commands([
            KafkaSubscribeCommand::class
        ]);
    }

    public function register(): void
    {
        $this->app->bind(
            KeywordRepositoryInterface::class,
            fn(Application $app) => new KeywordRepositoryByMySql(new Keyword($app->make('db')))
        );
        $this->app->bind(
            KeywordRegisteredListener::class,
            fn(Application $app) => new KeywordRegisteredListener($app->make(KeywordProducer::class))
        );
        $this->app->singleton(
            \Elasticsearch\Client::class, fn(Application $app) => $app->make(Client::class)->build()
        );
    }

    public function provides(): array
    {
        return [
            \Elasticsearch\Client::class,
            KafkaSubscribeCommand::class,
            KeywordRepositoryInterface::class,
            KeywordRegisteredListener::class,
        ];
    }
}

<?php
declare(strict_types=1);

namespace App\Providers;

use App\Foundation\Kafka\Client;
use App\Foundation\Kafka\Config;
use App\DataAccess\EntryProducer;
use App\DataAccess\EntryProducerFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use RdKafka\Conf;

final class KafkaServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $kafka = $this->app['config']['kafka'];
        $this->app->singleton(
            Config::class,
            fn(Application $app) => new Config(
                $kafka['topics']['entry']['client_id'],
                new Conf(),
                $this->app['log'],
            )
        );
        $this->app->bind(
            Client::class,
            fn(Application $app) => new Client($app->make(Config::class))
        );
        $this->app->singleton(
            EntryProducer::class,
            fn(Application $app) => (new EntryProducerFactory(
                $app->make(Client::class)->producer(),
                $kafka['brokers'],
                $kafka['topics']['entry']['created']
            ))->make()
        );
    }

    public function provides(): array
    {
        return [
            Config::class,
            Client::class,
            EntryProducer::class,
        ];
    }
}

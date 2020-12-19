<?php
declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands;
use App\DataAccess;
use App\DataAccess\KeywordProducer;
use App\Foundation\Elasticsearch\Client;
use App\Foundation\Kafka\Subscriber;
use App\Foundation\Kafka\SubscriberConfig;
use App\Listeners\KeywordRegisteredListener;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use RdKafka\Conf;
use RdKafka\Consumer;
use function sprintf;

final class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;
        $this->commands([
            Commands\KafkaSubscribeElasticsearchCommand::class,
            Commands\KafkaSubscribeMySqlCommand::class,
        ]);
        //
        $app->bindMethod(
            sprintf('%s@%s', Commands\KafkaSubscribeMySqlCommand::class, 'handle'),
            function (Commands\KafkaSubscribeMySqlCommand $command, Application $app) {
                $kafka = $app['config']['kafka'];
                $config = new SubscriberConfig(
                    $kafka['topics']['entry']['group_id_db'],
                    new Conf()
                );
                $command->handle(
                    $app->make(Subscriber::class),
                    new DataAccess\Database\RegisterKeyword($app->make('db')),
                    new Consumer($config->getKafkaConf())
                );
            }
        );
        $app->bindMethod(
            sprintf('%s@%s', Commands\KafkaSubscribeElasticsearchCommand::class, 'handle'),
            function (Commands\KafkaSubscribeElasticsearchCommand $command, Application $app) {
                $kafka = $app['config']['kafka'];
                $config = new SubscriberConfig(
                    $kafka['topics']['entry']['group_id_es'],
                    new Conf()
                );
                $command->handle(
                    $app->make(Subscriber::class),
                    new DataAccess\Elasticsearch\RegisterKeyword(
                        $app->make(\Elasticsearch\Client::class),
                        $app['config']['elasticsearch']['keyword_index']
                    ),
                    new Consumer($config->getKafkaConf())
                );
            }
        );
    }

    public function register(): void
    {
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
            KeywordRegisteredListener::class,
        ];
    }
}

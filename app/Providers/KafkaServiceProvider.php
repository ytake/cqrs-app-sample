<?php
declare(strict_types=1);

namespace App\Providers;

use App\Foundation\Kafka\Publisher;
use App\Foundation\Kafka\PublisherConfig;
use App\DataAccess\KeywordProducer;
use App\DataAccess\KeywordProducerFactory;
use App\Foundation\Kafka\PublisherConfigFactory;
use App\Foundation\Kafka\Subscriber;
use App\Foundation\Kafka\SubscriberFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use function array_keys;
use function array_merge;

final class KafkaServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /** @var array<string, string> */
    private array $factories = [
        PublisherConfig::class => PublisherConfigFactory::class,
        KeywordProducer::class => KeywordProducerFactory::class,
        Subscriber::class => SubscriberFactory::class,
    ];

    public function boot(): void
    {
        foreach ($this->factories as $class => $factory) {
            $this->app->singleton(
                $class,
                fn(Application $app) => (new $factory())->__invoke($app)
            );
        }
        $this->app->singleton(
            Publisher::class,
            fn(Application $app) => new Publisher($app->make(PublisherConfig::class))
        );
    }

    public function provides(): array
    {
        return array_merge(
            array_keys($this->factories),
            [Publisher::class]
        );
    }
}

<?php
declare(strict_types=1);

namespace App\DataAccess;

use App\Foundation\FactoryInterface;
use App\Foundation\Kafka\Publisher;
use App\Foundation\Serializer\JsonSerializer;
use Illuminate\Contracts\Foundation\Application;

final class KeywordProducerFactory implements FactoryInterface
{
    /**
     * @param Application $application
     * @return KeywordProducer
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(
        Application $application
    ): KeywordProducer {
        $kafka = $application['config']['kafka'];
        $producer = $application->make(Publisher::class)->producer();
        $producer->addBrokers($kafka['brokers']);
        return new KeywordProducer(
            $producer,
            $producer->newTopic($kafka['topics']['entry']['created']),
            new JsonSerializer(),
        );
    }
}

<?php
declare(strict_types=1);

namespace App\DataAccess;

use App\Foundation\FactoryInterface;
use App\Foundation\Kafka\Publisher;
use App\Foundation\Serializer\JsonSerializer;
use Illuminate\Contracts\Foundation\Application;

final class EntryProducerFactory implements FactoryInterface
{
    /**
     * @param Application $application
     * @return EntryProducer
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(
        Application $application
    ): EntryProducer {
        $kafka = $application['config']['kafka'];
        $producer = $application->make(Publisher::class)->producer();
        $producer->addBrokers($kafka['brokers']);
        return new EntryProducer(
            $producer,
            $producer->newTopic($kafka['topics']['entry']['created']),
            new JsonSerializer(),
        );
    }
}

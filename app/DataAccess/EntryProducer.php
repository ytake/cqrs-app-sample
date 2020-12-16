<?php
declare(strict_types=1);

namespace App\DataAccess;

use App\DataAccess\Kafka\ParameterInterface;
use App\Foundation\Serializer\SerializerInterface;
use RdKafka\Producer;
use RdKafka\ProducerTopic;
use const RD_KAFKA_PARTITION_UA;

final class EntryProducer
{
    public function __construct(
        private Producer $producer,
        private ProducerTopic $topic,
        private SerializerInterface $serializer
    ) {
    }

    public function add(
        ParameterInterface $parameter
    ): void {
        $this->topic->produce(
            RD_KAFKA_PARTITION_UA,
            0,
            $this->serializer->serialize($parameter->toArray())
        );
        $this->producer->poll(0);
    }
}

<?php
declare(strict_types=1);

namespace App\DataAccess;

use App\DataAccess\Kafka\ParameterInterface;
use App\Foundation\Serializer\SerializerInterface;
use RdKafka\Producer;
use RdKafka\ProducerTopic;
use function is_null;
use const RD_KAFKA_PARTITION_UA;

final class KeywordProducer implements KeywordProducerInterface
{
    /**
     * @param Producer $producer
     * @param ProducerTopic $topic
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private Producer $producer,
        private ProducerTopic $topic,
        private SerializerInterface $serializer
    ) {
    }

    /**
     * to Kafka
     * @param ParameterInterface $parameter
     */
    public function add(
        ParameterInterface $parameter
    ): void {
        $this->producer->initTransactions(10000);
        $this->producer->beginTransaction();
        $this->topic->produce(
            RD_KAFKA_PARTITION_UA,
            0,
            $this->serializer->serialize($parameter->toArray())
        );
        $this->producer->poll(0);
        $error = $this->producer->commitTransaction(10000);
        if ($error) {
            throw new \RuntimeException('Kafka Transaction Error.');
        }
    }
}

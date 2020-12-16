<?php
declare(strict_types=1);

namespace App\DataAccess;

use App\Foundation\Serializer\JsonSerializer;
use RdKafka\Producer;

final class EntryProducerFactory
{
    public function __construct(
        private Producer $producer,
        private string $broker,
        private string $topic,
    ) {
    }

    public function make(): EntryProducer
    {
        $this->producer->addBrokers($this->broker);
        return new EntryProducer(
            $this->producer,
            $this->producer->newTopic($this->topic),
            new JsonSerializer(),
        );
    }
}

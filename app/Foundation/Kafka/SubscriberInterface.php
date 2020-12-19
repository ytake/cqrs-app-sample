<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use RdKafka\Consumer;

interface SubscriberInterface
{
    /**
     * @param HandlerInterface $handler
     * @param Consumer $consumer
     * @param int $offset
     */
    public function handle(
        HandlerInterface $handler,
        Consumer $consumer,
        int $offset = RD_KAFKA_OFFSET_BEGINNING
    ): void;
}

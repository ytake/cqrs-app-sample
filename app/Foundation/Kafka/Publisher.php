<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use RdKafka\Producer;

final class Publisher
{
    public function __construct(
        private PublisherConfig $config,
    ) {}

    /**
     * @return Producer
     */
    public function producer(): Producer
    {
        return new Producer(
            $this->config->getKafkaConf()
        );
    }
}

<?php
declare(strict_types=1);

namespace App\DataAccess\Kafka;

use App\Foundation\Kafka\ConsumerInterface;
use Elasticsearch\Client;
use RdKafka\Message;

final class KeywordCreatedSubscribe implements ConsumerInterface
{
    /**
     * @param Client $client
     */
    public function __construct(
        private Client $client
    ) {
    }

    /**
     * @param Message $message
     */
    public function __invoke(
        Message $message
    ): void {
        // to Elasticsearch
    }
}

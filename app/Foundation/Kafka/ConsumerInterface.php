<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use RdKafka\Message;

interface ConsumerInterface
{
    public function __invoke(
        Message $message
    ): void;
}

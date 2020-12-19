<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use RdKafka\Message;

interface HandlerInterface
{
    /**
     * daemonでコールバックされる
     * @param Message $message
     */
    public function __invoke(
        Message $message
    ): void;
}

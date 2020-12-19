<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Foundation\Kafka\HandlerInterface;
use App\Foundation\Kafka\Subscriber;
use Illuminate\Console\Command;
use RdKafka\Consumer;

final class KafkaSubscribeMySqlCommand extends Command
{
    /** @var string */
    protected $name = 'sample:subscribe_mysql';

    /** @var string */
    protected $description = 'topic subscriber(to MySQL)';

    /**
     * @param Subscriber $subscriber
     * @param HandlerInterface $handler
     * @param Consumer $consumer
     */
    public function handle(
        Subscriber $subscriber,
        HandlerInterface $handler,
        Consumer $consumer
    ): void {
        $subscriber->handle($handler, $consumer);
    }
}

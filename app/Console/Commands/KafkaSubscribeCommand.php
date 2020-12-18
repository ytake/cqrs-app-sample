<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\DataAccess\Kafka\KeywordCreatedSubscribe;
use App\Foundation\Kafka\Subscriber;
use Illuminate\Console\Command;

final class KafkaSubscribeCommand extends Command
{
    /** @var string */
    protected $name = 'sample:subscribe';

    /** @var string */
    protected $description = 'topic subscriber(connect to Kafka Server)';

    public function handle(
        Subscriber $subscriber,
        KeywordCreatedSubscribe $consumer
    ): void {
        $subscriber->handle($consumer);
    }
}

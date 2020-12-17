<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use App\Foundation\FactoryInterface;
use Illuminate\Contracts\Foundation\Application;
use RdKafka\Conf;

final class SubscriberConfigFactory implements FactoryInterface
{
    public function __invoke(
        Application $application
    ): SubscriberConfig
    {
        $kafka = $application['config']['kafka'];
        return new SubscriberConfig(
            $kafka['topics']['entry']['group_id'],
            new Conf()
        );
    }
}

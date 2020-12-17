<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use App\Foundation\FactoryInterface;
use Illuminate\Contracts\Foundation\Application;
use RdKafka\Conf;

final class PublisherConfigFactory implements FactoryInterface
{
    /**
     * @param Application $application
     * @return PublisherConfig
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(
        Application $application
    ): PublisherConfig {
        $kafka = $application['config']['kafka'];
        return new PublisherConfig(
            $kafka['topics']['entry']['client_id'],
            new Conf(),
            $application->make('log')
        );
    }
}

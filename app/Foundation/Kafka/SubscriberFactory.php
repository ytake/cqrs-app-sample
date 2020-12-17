<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use App\Foundation\FactoryInterface;
use Illuminate\Contracts\Foundation\Application;
use RdKafka\Consumer;
use RdKafka\TopicConf;
use function sys_get_temp_dir;

final class SubscriberFactory implements FactoryInterface
{
    /**
     * @param Application $application
     * @return Subscriber
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(
        Application $application
    ): Subscriber
    {
        $kafka = $application['config']['kafka'];
        return new Subscriber(
            $kafka['brokers'],
            $kafka['topics']['entry']['created'],
            new Consumer(conf: $application->make(SubscriberConfig::class)),
            $this->getTopicConf()
        );
    }

    private function getTopicConf(): TopicConf
    {
        $conf = new TopicConf();
        $conf->set('auto.commit.interval.ms', '100');
        $conf->set('offset.store.method', 'file');
        $conf->set('offset.store.path', sys_get_temp_dir());
        $conf->set('auto.offset.reset', 'smallest');
        return $conf;
    }
}

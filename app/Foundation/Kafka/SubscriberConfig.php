<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use RdKafka\Conf;

final class SubscriberConfig
{
    /**
     * @param string $groupId
     * @param Conf $conf
     */
    public function __construct(
        private string $groupId,
        private Conf $conf
    ) {
    }

    /**
     * @return Conf
     */
    public function getKafkaConf(): Conf
    {
        $this->conf->set('group.id', $this->groupId);
        $this->conf->set('heartbeat.interval.ms', '10000');
        $this->conf->set('session.timeout.ms', '30000');
        $this->conf->set('topic.metadata.refresh.interval.ms', '60000');
        $this->conf->set('topic.metadata.refresh.sparse', 'true');
        $this->conf->set('log.connection.close', 'false');
        return $this->conf;
    }
}

<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use Psr\Log\LoggerInterface;
use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;
use function sprintf;
use function rd_kafka_err2str;

final class PublisherConfig
{
    public function __construct(
        private string $clientId,
        private Conf $conf,
        private LoggerInterface $logger
    ) {}

    /**
     * @return Conf
     */
    public function getKafkaConf(): Conf
    {
        $this->conf->set('client.id', $this->clientId);
        $this->conf->set('queue.buffering.max.ms', '1');
        $this->conf->set('queue.buffering.max.messages', '1000');
        $this->callbackDeliveryReport($this->conf);
        return $this->conf;
    }

    private function callbackDeliveryReport(
        Conf $conf
    ): void {
        $conf->setDrMsgCb(fn(Producer $kafka, Message $message) => $this->logWrite($message));
        $conf->setErrorCb(fn($rk, $err, $reason) => $this->logger->error(
            sprintf("Kafka error: %s (reason: %s)", rd_kafka_err2str($err), $reason)
        ));
    }

    /**
     * @param Message $message
     */
    private function logWrite(Message $message): void
    {
        if ($message->err) {
            $this->logger->error('delivery failed', [
                'topic' => $message->topic_name,
                'payload' => $message->errstr(),
            ]);
        }
    }
}

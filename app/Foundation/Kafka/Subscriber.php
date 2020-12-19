<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use App\Foundation\Kafka\Exception\SubscriberTimeoutException;
use RdKafka\Consumer;
use RdKafka\Message;
use RdKafka\TopicConf;
use function call_user_func;
use const RD_KAFKA_OFFSET_STORED;
use const RD_KAFKA_RESP_ERR_NO_ERROR;
use const RD_KAFKA_RESP_ERR__TIMED_OUT;

class Subscriber implements SubscriberInterface
{
    /** @var int Kafka Topic Partition */
    protected int $partition = 0;

    /**
     * @param string $broker
     * @param string $topic
     * @param TopicConf $topicConf
     */
    public function __construct(
        private string $broker,
        private string $topic,
        private TopicConf $topicConf
    ) {
    }

    /**
     * @param HandlerInterface $handler
     * @param Consumer $consumer
     * @param int $offset
     */
    public function handle(
        HandlerInterface $handler,
        Consumer $consumer,
        int $offset = RD_KAFKA_OFFSET_STORED
    ): void {
        $consumer->addBrokers($this->broker);
        $topic = $consumer->newTopic($this->topic, $this->topicConf);
        $topic->consumeStart($this->partition, $offset);
        while (true) {
            $message = $topic->consume($this->partition, 120 * 10000);
            if ($message instanceof Message) {
                match ($message->err) {
                    RD_KAFKA_RESP_ERR_NO_ERROR => call_user_func($handler, $message),
                    RD_KAFKA_RESP_ERR__TIMED_OUT => throw new SubscriberTimeoutException('time out.'),
                };
            }
        }
    }
}

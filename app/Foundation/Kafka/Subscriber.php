<?php
declare(strict_types=1);

namespace App\Foundation\Kafka;

use App\Foundation\Kafka\Exception\SubscriberTimeoutException;
use RdKafka\Consumer;
use RdKafka\Message;
use RdKafka\TopicConf;
use function call_user_func;
use const RD_KAFKA_OFFSET_END;
use const RD_KAFKA_RESP_ERR_NO_ERROR;
use const RD_KAFKA_RESP_ERR__TIMED_OUT;

class Subscriber
{
    /** @var int Kafka Topic Partition */
    protected int $partition = 0;

    public function __construct(
        private string $broker,
        private string $topic,
        private Consumer $consumer,
        private TopicConf $topicConf
    ) {
    }

    /**
     * @param ConsumerInterface $consumer
     * @param int $offset
     */
    public function handle(
        ConsumerInterface $consumer,
        int $offset = RD_KAFKA_OFFSET_END
    ): void {
        $this->consumer->addBrokers($this->broker);
        $topic = $this->consumer->newTopic($this->topic, $this->topicConf);
        $topic->consumeStart($this->partition, $offset);
        while (true) {
            $message = $topic->consume($this->partition, 120 * 10000);
            if ($message instanceof Message) {
                match ($message->err) {
                    RD_KAFKA_RESP_ERR_NO_ERROR => call_user_func($consumer, $message),
                    RD_KAFKA_RESP_ERR__TIMED_OUT => throw new SubscriberTimeoutException('time out.'),
                };
            }
        }
    }
}

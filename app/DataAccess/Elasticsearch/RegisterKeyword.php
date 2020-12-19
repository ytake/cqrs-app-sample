<?php
declare(strict_types=1);

namespace App\DataAccess\Elasticsearch;

use DateTime;
use App\Foundation\Kafka\HandlerInterface;
use Elasticsearch\Client;
use RdKafka\Message;

class RegisterKeyword implements HandlerInterface
{
    /**
     * @param Client $client
     * @param string $index
     */
    public function __construct(
        private Client $client,
        private string $index
    ) {
    }

    /**
     * @param Message $message
     * @throws \JsonException
     */
    public function __invoke(
        Message $message
    ): void {
        $decoded = json_decode($message->payload, false, 512, JSON_THROW_ON_ERROR);
        $word = '';
        /**
         * DB側の読み込みモデル更新と異なり、userは不用なので
         * bodyのみ確認します
         */
        if (isset($decoded->body)) {
            $word = $decoded->body;
        }
        if ($word === '') {
            return;
        }
        $d = new DateTime();
        $this->client->index([
            'index' => $this->index,
            'body' => [
                'word_field' => $word,
                'created' => $d->format('Y-m-d\TH:i:s')
            ]
        ]);
    }
}

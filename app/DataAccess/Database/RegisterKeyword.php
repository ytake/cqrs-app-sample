<?php
declare(strict_types=1);

namespace App\DataAccess\Database;

use App\Foundation\Kafka\HandlerInterface;
use Illuminate\Database\Connection;
use PDOException;
use Illuminate\Database\DatabaseManager;
use RdKafka\Message;
use function count;
use const JSON_THROW_ON_ERROR;

final class RegisterKeyword implements HandlerInterface
{
    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(
        private DatabaseManager $databaseManager
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
        $user = 0;
        /**
         * 本アプリケーションではCommand側で確実な値を挿入していますが、
         * 違うアプリケーションからPublishされた場合に、Kafka Streamsなどでフィルターしていない限り
         * 予期せぬ値が挿入されるケースも多々あります。
         */
        if (isset($decoded->body)) {
            $word = $decoded->body;
        }
        if (isset($decoded->user_id)) {
            $user = $decoded->user_id;
        }
        if ($word === '' && $user === 0) {
            return;
        }
        try {
            $this->databaseManager->connection('mysql')->transaction(
                fn(Connection $con) => $con->table('keywords')->insert([
                    'word' => $word,
                    'user_id' => $user,
                ])
            );
            $this->databaseManager->disconnect('mysql');
        } catch (PDOException $e) {
            // daemonで実行されるためインスタンスが破棄されないので処理完了時に切断しましょう
            if (count($this->databaseManager->getConnections())) {
                $this->databaseManager->disconnect('mysql');
            }
        }
    }
}

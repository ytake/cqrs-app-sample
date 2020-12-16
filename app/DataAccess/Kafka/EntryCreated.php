<?php
declare(strict_types=1);

namespace App\DataAccess\Kafka;

final class EntryCreated implements ParameterInterface
{
    public function __construct(
        private string $body,
        private int $userId,
    ) {
    }

    #[\JetBrains\PhpStorm\ArrayShape(
        ['body' => "string", 'user_id' => "int"])
    ]
    public function toArray(): array
    {
        return [
            'body' => $this->body,
            'user_id' => $this->userId,
        ];
    }
}

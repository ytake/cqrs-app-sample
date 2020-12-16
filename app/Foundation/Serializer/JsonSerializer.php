<?php
declare(strict_types=1);

namespace App\Foundation\Serializer;

use function json_encode;
use const JSON_THROW_ON_ERROR;

final class JsonSerializer implements SerializerInterface
{
    /**
     * @inheritdoc
     * @throws \JsonException
     */
    public function serialize(
        array $values
    ): string {
        return json_encode($values, JSON_THROW_ON_ERROR);
    }
}

<?php
declare(strict_types=1);

namespace App\Foundation\Serializer;

interface SerializerInterface
{
    /**
     * @param array $values
     * @return string
     */
    public function serialize(
        array $values
    ): string;
}

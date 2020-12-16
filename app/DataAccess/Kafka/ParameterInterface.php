<?php
declare(strict_types=1);

namespace App\DataAccess\Kafka;

interface ParameterInterface
{
    public function toArray(): array;
}

<?php
declare(strict_types=1);

namespace App\DataAccess;

use App\DataAccess\Kafka\ParameterInterface;

interface KeywordProducerInterface
{
    /**
     * @param ParameterInterface $parameter
     */
    public function add(
        ParameterInterface $parameter
    ): void;
}

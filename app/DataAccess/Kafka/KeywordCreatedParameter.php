<?php
declare(strict_types=1);

namespace App\DataAccess\Kafka;

use SampleDomain\Keyword\Entity\Keyword;

final class KeywordCreatedParameter implements ParameterInterface
{
    /**
     * @param Keyword $keyword
     */
    public function __construct(
        private Keyword $keyword
    ) {
    }

    #[\JetBrains\PhpStorm\ArrayShape(
        ['body' => "string", 'user_id' => "int"])
    ]
    public function toArray(): array
    {
        return [
            'body' => $this->keyword->getWord(),
            'user_id' => $this->keyword->getUserId()->value(),
        ];
    }
}

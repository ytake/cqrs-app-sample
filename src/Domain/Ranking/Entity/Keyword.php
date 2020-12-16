<?php
declare(strict_types=1);

namespace SampleDomain\Ranking\Entity;

final class Keyword
{
    public function __construct(
        private string $word
    ) {
    }

    public function getWord(): string
    {
        return $this->word;
    }
}

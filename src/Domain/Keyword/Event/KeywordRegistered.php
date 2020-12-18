<?php
declare(strict_types=1);

namespace SampleDomain\Keyword\Event;

use SampleDomain\Keyword\Entity\Keyword;

final class KeywordRegistered
{
    /**
     * @param Keyword $keyword
     */
    public function __construct(
        private Keyword $keyword
    ) {
    }

    /**
     * @return Keyword
     */
    public function getKeyword(): Keyword
    {
        return $this->keyword;
    }
}

<?php
declare(strict_types=1);

namespace SampleDomain\Keyword\Repository;

use SampleDomain\Keyword\Entity\Keyword;

interface KeywordRepositoryInterface
{
    /**
     * @param Keyword $word
     */
    public function save(
        Keyword $word
    ): void;
}

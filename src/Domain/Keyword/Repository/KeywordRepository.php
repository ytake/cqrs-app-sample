<?php
declare(strict_types=1);

namespace SampleDomain\Keyword\Repository;

use SampleDomain\Keyword\Entity\Keyword;
use SampleDomain\Keyword\Entity\KeywordCriteriaInterface;

final class KeywordRepository
{
    public function __construct(
        private KeywordCriteriaInterface $criteria
    ) {
    }

    public function save(Keyword $word): void
    {
        $this->criteria->add($word);
    }
}

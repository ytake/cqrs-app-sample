<?php
declare(strict_types=1);

namespace SampleDomain\Word\Repository;

use SampleDomain\Word\Entity\Word;
use SampleDomain\Word\Entity\WordCriteriaInterface;

final class WordRepository
{
    public function __construct(
        private WordCriteriaInterface $criteria
    ) {
    }

    public function save(Word $word): void
    {
        $this->criteria->add($word);
    }
}

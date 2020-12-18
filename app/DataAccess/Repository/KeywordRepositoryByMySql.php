<?php
declare(strict_types=1);

namespace App\DataAccess\Repository;

use SampleDomain\Keyword\Entity\Keyword;
use SampleDomain\Keyword\Repository\KeywordRepositoryInterface;

final class KeywordRepositoryByMySql implements KeywordRepositoryInterface
{
    public function __construct(
        private \App\DataAccess\Database\Keyword $dataAccess
    ) {
    }

    /**
     * @param Keyword $word
     */
    public function save(
        Keyword $word
    ): void {
        $this->dataAccess->add($word);
    }
}

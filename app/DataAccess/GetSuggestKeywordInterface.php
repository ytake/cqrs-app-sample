<?php
declare(strict_types=1);

namespace App\DataAccess;

interface GetSuggestKeywordInterface
{
    /**
     * @param string $word
     * @return array
     */
    public function findByWord(
        string $word
    ): array;
}

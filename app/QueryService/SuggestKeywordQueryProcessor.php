<?php
declare(strict_types=1);

namespace App\QueryService;

use App\Transfer\Keyword;
use Generator;
use App\DataAccess\GetSuggestKeywordInterface;

final class SuggestKeywordQueryProcessor
{
    /**
     * @param GetSuggestKeywordInterface $suggestKeyword
     */
    public function __construct(
        private GetSuggestKeywordInterface $suggestKeyword
    ) {
    }

    /**
     * @param string $word
     * @return Generator
     */
    public function run(string $word): Generator
    {
        foreach ($this->suggestKeyword->findByWord($word) as $row) {
            yield new Keyword($row['key'], $row['doc_count']);
        }
    }
}

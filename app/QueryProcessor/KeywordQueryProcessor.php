<?php
declare(strict_types=1);

namespace App\QueryProcessor;

use Generator;
use App\DataAccess\GetKeywordInterface;
use App\Transfer\Keyword;

final class KeywordQueryProcessor
{
    /**
     * @param GetKeywordInterface $keyword
     */
    public function __construct(
        private GetKeywordInterface $keyword
    ) {
    }

    /**
     * @return Generator<Keyword>
     */
    public function run(): Generator
    {
        foreach ($this->keyword->findAll() as $row) {
            yield new Keyword($row['key'], $row['doc_count']);
        }
    }
}

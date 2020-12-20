<?php
declare(strict_types=1);

namespace Tests\Unit\QueryProcessor;

use App\DataAccess\GetSuggestKeywordInterface;
use App\QueryProcessor\SuggestKeywordQueryProcessor;
use App\Transfer\Keyword;
use Tests\TestCase;
use function iterator_to_array;

final class TestSuggestKeywordQueryProcessor extends TestCase
{
    public function testShouldReturnKeywordGenerator(): void
    {
        $processor = new SuggestKeywordQueryProcessor(
            $this->createDao([
                [
                    'key' => 'testing',
                    'doc_count' => 1
                ]
            ])
        );
        $result = iterator_to_array($processor->run('testing'));
        $this->assertContainsOnlyInstancesOf(Keyword::class, $result);
        $this->assertCount(1, $result);
    }

    public function testShouldReturnEmptyKeywordGenerator(): void
    {
        $processor = new SuggestKeywordQueryProcessor(
            $this->createDao([])
        );
        $result = iterator_to_array($processor->run('testing'));
        $this->assertCount(0, $result);
    }
    private function createDao(
        array $values
    ): GetSuggestKeywordInterface {
        return new class($values) implements GetSuggestKeywordInterface {
            public function __construct(
                private array $values
            ) {
            }
            public function findByWord(
                string $word
            ): array {
                return $this->values;
            }
        };
    }
}

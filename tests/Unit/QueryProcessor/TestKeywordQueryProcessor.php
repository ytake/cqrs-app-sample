<?php
declare(strict_types=1);

namespace Tests\Unit\QueryProcessor;

use App\DataAccess\GetKeywordInterface;
use App\QueryProcessor\KeywordQueryProcessor;
use App\Transfer\Keyword;
use Tests\TestCase;
use function iterator_to_array;

final class TestKeywordQueryProcessor extends TestCase
{
    public function testShouldReturnKeywordGenerator(): void
    {
        $processor = new KeywordQueryProcessor(
            $this->createDao([
                [
                    'key' => 'testing',
                    'doc_count' => 1
                ]
            ])
        );
        $result = iterator_to_array($processor->run());
        $this->assertContainsOnlyInstancesOf(Keyword::class, $result);
        $this->assertCount(1, $result);
    }

    public function testShouldReturnEmptyKeywordGenerator(): void
    {
        $processor = new KeywordQueryProcessor(
            $this->createDao([])
        );
        $result = iterator_to_array($processor->run());
        $this->assertCount(0, $result);
    }

    private function createDao(
        array $values
    ): GetKeywordInterface {
        return new class($values) implements GetKeywordInterface {
            public function __construct(
                private array $values
            ) {
            }

            public function findAll(): array
            {
                return $this->values;
            }
        };
    }
}

<?php
declare(strict_types=1);

namespace App\DataAccess\Elasticsearch;

use App\DataAccess\GetKeywordInterface;
use Elasticsearch\Client;

final class SortedKeyword implements GetKeywordInterface
{
    use AggregateQuery;

    /**
     * @param Client $client
     * @param string $index
     */
    public function __construct(
        private Client $client,
        private string $index
    ) {
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $result = $this->client->search([
            'index' => $this->index,
            'body' => $this->aggsQuery(),
        ]);
        return $result['aggregations']['keyword']['buckets'];
    }
}

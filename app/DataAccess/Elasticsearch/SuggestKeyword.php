<?php
declare(strict_types=1);

namespace App\DataAccess\Elasticsearch;

use App\DataAccess\GetSuggestKeywordInterface;
use Elasticsearch\Client;
use function array_merge;

final class SuggestKeyword implements GetSuggestKeywordInterface
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
     * @param string $word
     * @return array
     */
    public function findByWord(
        string $word
    ): array {
        $params = [
            'index' => $this->index,
            'body' => $this->aggsQuery(),
        ];
        if ($word !== '') {
            $params['body'] = array_merge($params['body'], [
                'query' => $this->suggestMatchQuery($word)
            ]);
        }
        $result = $this->client->search($params);
        return $result['aggregations']['keyword']['buckets'];
    }

    /**
     * @param string $word
     * @return array
     */
    private function suggestMatchQuery(
        string $word
    ): array {
        return  [
            'bool' => [
                'should' => [
                    [
                        'match' => [
                            'word_field.suggest' => [
                                'query' => $word
                            ]
                        ]
                    ],
                    [
                        'match' => [
                            'word_field.readingform' => [
                                'query' => $word,
                                'fuzziness' => 'AUTO',
                                'operator' => 'and'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}

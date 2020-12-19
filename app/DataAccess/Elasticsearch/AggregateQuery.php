<?php
declare(strict_types=1);

namespace App\DataAccess\Elasticsearch;

trait AggregateQuery
{
    /**
     * @return array[]
     */
    private function aggsQuery(): array
    {
        return [
            'size' => 0,
            'aggs' => [
                'keyword' => [
                    'terms' => [
                        'field' => 'word_field',
                        'order' => [
                            '_count' => 'desc'
                        ],
                        'size' => 100
                    ]
                ]
            ]
        ];
    }
}

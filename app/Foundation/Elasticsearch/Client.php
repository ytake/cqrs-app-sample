<?php
declare(strict_types=1);

namespace App\Foundation\Elasticsearch;

use Elasticsearch\ClientBuilder;

final class Client
{
    public function __construct(
        private array $hosts
    ) {
    }

    public function build(): \Elasticsearch\Client
    {
        return ClientBuilder::create()
            ->setHosts($this->hosts)
            ->build();
    }
}

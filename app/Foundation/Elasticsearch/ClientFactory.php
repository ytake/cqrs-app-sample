<?php
declare(strict_types=1);

namespace App\Foundation\Elasticsearch;

use App\Foundation\FactoryInterface;
use Illuminate\Contracts\Foundation\Application;

final class ClientFactory implements FactoryInterface
{
    public function __invoke(
        Application $application
    ): Client {
        return new Client(
            $application['config']['elasticsearch']['hosts']
        );
    }
}

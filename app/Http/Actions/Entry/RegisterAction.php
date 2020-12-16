<?php
declare(strict_types=1);

namespace App\Http\Actions\Entry;

use App\DataAccess\EntryProducer;
use App\DataAccess\Kafka\EntryCreated;

final class RegisterAction
{
    public function __construct(
        private EntryProducer $c
    ) {}

    public function __invoke()
    {
        $this->c->add(
            new EntryCreated('hello', 1)
        );
    }
}

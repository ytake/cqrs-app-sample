<?php
declare(strict_types=1);

namespace App\Listeners;

use App\DataAccess\Kafka\KeywordCreatedParameter;
use App\DataAccess\KeywordProducerInterface;
use SampleDomain\Keyword\Event\KeywordRegistered;

class KeywordRegisteredListener
{
    /**
     * @param KeywordProducerInterface $producer
     */
    public function __construct(
        private KeywordProducerInterface $producer
    ) {
    }

    /**
     * @param KeywordRegistered $event
     */
    public function handle(
        KeywordRegistered $event
    ): void {
        $this->producer->add(
            new KeywordCreatedParameter(
                $event->getKeyword()
            )
        );
    }
}

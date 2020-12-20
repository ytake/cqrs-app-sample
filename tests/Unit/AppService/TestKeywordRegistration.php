<?php
declare(strict_types=1);

namespace Tests\Unit\AppService;

use App\AppService\KeywordRegistration;
use App\DataAccess\Kafka\ParameterInterface;
use App\DataAccess\KeywordProducerInterface;
use App\Listeners\KeywordRegisteredListener;
use Illuminate\Events\Dispatcher;
use SampleDomain\Keyword\Event\KeywordRegistered;
use Tests\TestCase;

final class TestKeywordRegistration extends TestCase
{
    private KeywordRegistration $usecase;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var \Illuminate\Log\LogManager $log */
        $log = $this->app['log'];
        $log->setDefaultDriver('monolog');
        $this->usecase = new KeywordRegistration(
            $log,
            $this->app['events']
        );
    }

    public function testShouldKeywordRegisteredEventDispatch(): void
    {
        /** @var Dispatcher $event */
        $event = $this->app['events'];
        $event->forget(KeywordRegistered::class);
        $event->listen(
            KeywordRegistered::class,
            $this->createListener($this->createProducer())
        );
        $this->usecase->register(1, 'testing');
    }

    public function testShouldThrow(): void
    {
        /** @var Dispatcher $event */
        $event = $this->app['events'];
        $event->forget(KeywordRegistered::class);
        $event->listen(
            KeywordRegistered::class,
            $this->createListener($this->createProducer())
        );
        $this->expectException(
            \SampleDomain\Support\Exception\InvalidNativeArgumentException::class
        );
        $this->usecase->register(-1, 'testing');
    }

    private function createListener(
        KeywordProducerInterface $producer
    ): KeywordRegisteredListener {
        return new class($producer) extends KeywordRegisteredListener {
            public function __invoke(KeywordRegistered $event): void
            {
                TestCase::assertSame(1, $event->getKeyword()->getUserId()->value());
                TestCase::assertSame('testing', $event->getKeyword()->getWord());
            }
        };
    }

    private function createProducer(): KeywordProducerInterface
    {
        return new class() implements KeywordProducerInterface {
            public function add(ParameterInterface $parameter): void
            {
                // Kafkaへの送信にあたる処理
                // テストでは実行しない
            }
        };
    }
}

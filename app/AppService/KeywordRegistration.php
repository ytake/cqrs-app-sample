<?php
declare(strict_types=1);

namespace App\AppService;

use Psr\Log\LoggerInterface;
use SampleDomain\Keyword\Event\KeywordRegistered;
use Illuminate\Contracts\Events\Dispatcher;
use SampleDomain\Keyword\Entity\Keyword;
use SampleDomain\User\ValueObject\UserId;
use Ytake\LaravelAspect\Annotation\LogExceptions;

/**
 * Usecase
 */
class KeywordRegistration
{
    /**
     * @param LoggerInterface $logger
     * @param Dispatcher $dispatcher
     */
    public function __construct(
        private LoggerInterface $logger,
        private Dispatcher $dispatcher
    ) {
    }

    /**
     * キーワードを登録する
     * @LogExceptions()
     * @param int $id
     * @param string $text
     */
    public function register(
        int $id,
        string $text
    ): void {
        $keyword = new Keyword(new UserId($id), $text);
        // Eventを発行
        $this->dispatcher->dispatch(new KeywordRegistered($keyword));
        $this->logger->info('publish', ['object' => $keyword]);
    }
}

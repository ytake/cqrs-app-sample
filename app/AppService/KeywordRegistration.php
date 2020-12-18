<?php
declare(strict_types=1);

namespace App\AppService;

use SampleDomain\Keyword\Event\KeywordRegistered;
use Illuminate\Contracts\Events\Dispatcher;
use SampleDomain\Keyword\Entity\Keyword;
use SampleDomain\Keyword\Repository\KeywordRepository;
use SampleDomain\User\ValueObject\UserId;
use Ytake\LaravelAspect\Annotation\LogExceptions;
use Ytake\LaravelAspect\Annotation\Transactional;

/**
 * Usecase
 */
class KeywordRegistration
{
    /**
     * @param KeywordRepository $repository
     * @param Dispatcher $dispatcher
     */
    public function __construct(
        private KeywordRepository $repository,
        private Dispatcher $dispatcher
    ) {
    }

    /**
     * キーワードを登録する
     * @Transactional("mysql")
     * @LogExceptions()
     * @param int $id
     * @param string $text
     */
    public function register(
        int $id,
        string $text
    ): void {
        $keyword = new Keyword(new UserId($id), $text);
        $this->repository->save($keyword);
        $this->dispatcher->dispatch(new KeywordRegistered($keyword));
    }
}

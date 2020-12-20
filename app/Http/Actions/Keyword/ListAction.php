<?php
declare(strict_types=1);

namespace App\Http\Actions\Keyword;

use App\Http\Responder\Keyword\ListResponder;
use App\QueryProcessor\KeywordQueryProcessor;
use Symfony\Component\HttpFoundation\Response;

final class ListAction
{
    /**
     * @param KeywordQueryProcessor $keywordProcessor
     * @param ListResponder $responder
     */
    public function __construct(
        private KeywordQueryProcessor $keywordProcessor,
        private ListResponder $responder
    ) {
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->responder->render(
            $this->keywordProcessor->run()
        );
    }
}

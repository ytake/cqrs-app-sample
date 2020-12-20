<?php
declare(strict_types=1);

namespace App\Http\Actions\Keyword;

use App\Http\Responder\Keyword\SuggestResponder;
use App\QueryProcessor\SuggestKeywordQueryProcessor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SuggestAction
{
    /**
     * @param SuggestKeywordQueryProcessor $keywordProcessor
     * @param SuggestResponder $responder
     */
    public function __construct(
        private SuggestKeywordQueryProcessor $keywordProcessor,
        private SuggestResponder $responder
    ) {
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(
        Request $request
    ): Response {
        $word = $request->get('word');
        return $this->responder->render(
            $this->keywordProcessor->run(
                match ($word) {
                    null => '',
                    default => $word
                }
            )
        );
    }
}

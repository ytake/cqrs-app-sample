<?php
declare(strict_types=1);

namespace App\Http\Responder\Keyword;

use Generator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;

final class SuggestResponder
{
    /**
     * @param Factory $view
     */
    public function __construct(
        private Factory $view
    ) {
    }

    /**
     * @param Generator $generator
     * @return Response
     */
    public function render(
        Generator $generator
    ): Response {
        return new Response(
            $this->view->make('keyword.suggest', [
                'list' => $generator
            ])
        );
    }
}

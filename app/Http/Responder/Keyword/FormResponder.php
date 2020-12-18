<?php
declare(strict_types=1);

namespace App\Http\Responder\Keyword;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;

final class FormResponder
{
    /**
     * @param Factory $view
     */
    public function __construct(
        private Factory $view
    ) {}

    public function render(): Response
    {
        return new Response(
            $this->view->make('keyword.form'),
            Response::HTTP_OK
        );
    }
}

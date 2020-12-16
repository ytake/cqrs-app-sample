<?php
declare(strict_types=1);

namespace App\Http\Responder;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;

final class HomeResponder
{
    public function __construct(
        private Factory $view
    ) {}

    /**
     * @return Response
     */
    public function emit(): Response
    {
        return new Response(
            $this->view->make('home'),
            Response::HTTP_OK
        );
    }
}

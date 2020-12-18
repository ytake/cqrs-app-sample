<?php
declare(strict_types=1);

namespace App\Http\Actions\Keyword;

use App\Http\Responder\Keyword\FormResponder;
use Symfony\Component\HttpFoundation\Response;

final class FormAction
{
    public function __construct(
        private FormResponder $responder
    ) {
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->responder->render();
    }
}

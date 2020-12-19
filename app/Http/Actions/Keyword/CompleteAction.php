<?php
declare(strict_types=1);

namespace App\Http\Actions\Keyword;

use App\Http\Responder\Keyword\CompleteResponder;
use Symfony\Component\HttpFoundation\Response;

final class CompleteAction
{
    /**
     * @param CompleteResponder $responder
     */
    public function __construct(
        private CompleteResponder $responder
    ) {
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->responder->redirectToForm();
    }
}

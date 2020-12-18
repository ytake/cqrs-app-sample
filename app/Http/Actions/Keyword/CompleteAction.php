<?php
declare(strict_types=1);

namespace App\Http\Actions\Keyword;

use App\Http\Responder\Keyword\CompleteResponder;
use Illuminate\Http\RedirectResponse;

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
     * @return RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        return $this->responder->redirectToForm();
    }
}

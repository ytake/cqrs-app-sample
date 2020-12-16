<?php
declare(strict_types=1);

namespace App\Http\Actions;

use App\Http\Responder\HomeResponder;
use Symfony\Component\HttpFoundation\Response;

final class HomeAction
{
    public function __construct(
        private HomeResponder $responder
    ) {}

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->responder->emit();
    }
}

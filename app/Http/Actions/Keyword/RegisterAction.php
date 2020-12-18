<?php
declare(strict_types=1);

namespace App\Http\Actions\Keyword;

use App\AppService\KeywordRegistration;
use App\Http\Requests\KeywordRequest;
use App\Http\Responder\Keyword\RegisterResponder;
use SampleDomain\Keyword\Entity\Keyword;
use SampleDomain\User\ValueObject\UserId;
use Symfony\Component\HttpFoundation\Response;

final class RegisterAction
{
    /**
     * @param KeywordRegistration $registration
     * @param RegisterResponder $responder
     */
    public function __construct(
        private KeywordRegistration $registration,
        private RegisterResponder $responder
    ) {}

    /**
     * @param KeywordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(
        KeywordRequest $request
    ): Response {
        if($request->exists('submit')) {
            $this->registration->register(1, $request->get('word'));
            return $this->responder->redirectToComplete();
        }
        return $this->responder->redirectToForm();
    }
}

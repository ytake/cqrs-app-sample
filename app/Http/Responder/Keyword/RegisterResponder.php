<?php
declare(strict_types=1);

namespace App\Http\Responder\Keyword;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

final class RegisterResponder
{
    /**
     * @param Redirector $redirector
     */
    public function __construct(
        private Redirector $redirector
    ) {
    }

    /**
     * @return RedirectResponse
     */
    public function redirectToForm(): RedirectResponse
    {
        return $this->redirector->route('keyword.form')
            ->withInput();
    }

    public function redirectToComplete(): RedirectResponse
    {
        return $this->redirector->route('keyword.complete')
            ->withInput();
    }
}

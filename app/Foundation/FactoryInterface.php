<?php
declare(strict_types=1);

namespace App\Foundation;

use Illuminate\Contracts\Foundation\Application;

interface FactoryInterface
{
    public function __invoke(
        Application $application
    ): object;
}

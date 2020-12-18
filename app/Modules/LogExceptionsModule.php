<?php
declare(strict_types=1);

namespace App\Modules;

use App\AppService\KeywordRegistration;
use Ytake\LaravelAspect\Modules\LogExceptionsModule as PackageLogExceptionsModule;

/**
 * Class LogExceptionsModule
 */
final class LogExceptionsModule extends PackageLogExceptionsModule
{
    /** @var string[] */
    protected $classes = [
        KeywordRegistration::class,
    ];
}

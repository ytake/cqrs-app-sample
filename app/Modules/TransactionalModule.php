<?php
declare(strict_types=1);

namespace App\Modules;

use App\AppService\KeywordRegistration;
use Ytake\LaravelAspect\Modules\TransactionalModule as PackageTransactionalModule;

/**
 * Class TransactionalModule
 */
final class TransactionalModule extends PackageTransactionalModule
{
    /** @var string[] */
    protected $classes = [
        KeywordRegistration::class,
    ];
}

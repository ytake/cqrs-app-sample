<?php
declare(strict_types=1);

namespace App\Providers;

use SampleDomain\Keyword\Event\KeywordRegistered;
use App\Listeners\KeywordRegisteredListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

final class EventServiceProvider extends ServiceProvider
{
    /** @var \string[][] */
    protected $listen = [
        KeywordRegistered::class => [
            KeywordRegisteredListener::class,
        ],
    ];
}

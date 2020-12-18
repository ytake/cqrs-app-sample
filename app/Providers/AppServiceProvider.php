<?php
declare(strict_types=1);

namespace App\Providers;

use App\DataAccess\Database\Keyword;
use App\DataAccess\KeywordProducer;
use App\Listeners\KeywordRegisteredListener;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use SampleDomain\Keyword\Repository\KeywordRepository;

final class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(
            KeywordRepository::class,
            fn(Application $app) => new KeywordRepository(new Keyword($app->make('db')))
        );
        $this->app->bind(
            KeywordRegisteredListener::class,
            fn(Application $app) => new KeywordRegisteredListener($app->make(KeywordProducer::class))
        );
    }

    public function provides(): array
    {
        return [
            KeywordRepository::class,
            KeywordRegisteredListener::class,
        ];
    }
}

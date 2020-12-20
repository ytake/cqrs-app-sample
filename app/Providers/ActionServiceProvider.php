<?php
declare(strict_types=1);

namespace App\Providers;

use App\DataAccess\Elasticsearch\SortedKeyword;
use App\DataAccess\Elasticsearch\SuggestKeyword;
use App\Http\Actions\Keyword\ListAction;
use App\Http\Actions\Keyword\SuggestAction;
use App\Http\Responder\Keyword\ListResponder;
use App\Http\Responder\Keyword\SuggestResponder;
use App\QueryProcessor\KeywordQueryProcessor;
use App\QueryProcessor\SuggestKeywordQueryProcessor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class ActionServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ListAction::class,
            fn(Application $app) => new ListAction(
                new KeywordQueryProcessor($app->make(SortedKeyword::class)),
                $app->make(ListResponder::class)
            )
        );
        $this->app->singleton(
            SuggestAction::class,
            fn(Application $app) => new SuggestAction(
                new SuggestKeywordQueryProcessor($app->make(SuggestKeyword::class)),
                $app->make(SuggestResponder::class)
            )
        );
    }

    public function provides(): array
    {
        return [
            SuggestAction::class,
            ListAction::class,
        ];
    }
}

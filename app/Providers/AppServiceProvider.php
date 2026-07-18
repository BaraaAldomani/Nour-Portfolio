<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Dish;
use App\Models\EducationItem;
use App\Models\Experience;
use App\Models\Metric;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Observers\ContentObserver;
use App\Services\SiteContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Every model whose contents are editable in the dashboard. Each one gets
     * the cache-flushing observer.
     *
     * @var array<int, class-string<Model>>
     */
    private const OBSERVED = [
        Dish::class,
        EducationItem::class,
        Experience::class,
        Metric::class,
        ProcessStep::class,
        Service::class,
        Setting::class,
        Skill::class,
    ];

    public function register(): void
    {
        // One read layer per request, shared by the helpers, the observer and
        // every view.
        $this->app->singleton(SiteContent::class);
    }

    public function boot(): void
    {
        Model::unguard(false);
        Model::preventLazyLoading(! $this->app->isProduction());

        foreach (self::OBSERVED as $model) {
            $model::observe(ContentObserver::class);
        }

        // $site is available in every Blade template without any controller
        // having to pass it.
        View::share('site', $this->app->make(SiteContent::class));
    }
}

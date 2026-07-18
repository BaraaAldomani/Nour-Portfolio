<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dish;
use App\Models\EducationItem;
use App\Models\Experience;
use App\Models\Metric;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Support\SettingsDefaults;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * The single read layer for everything the public site renders.
 *
 * Registered as a singleton and shared into every view as `$site`, so a Blade
 * template never touches Eloquent directly and there is exactly one place where
 * caching decisions are made.
 */
final class SiteContent
{
    /**
     * The settings map: a plain nested array, safe to cache persistently.
     *
     * @var array<string, array<string, mixed>>|null
     */
    private ?array $settings = null;

    /**
     * Per-request memo for content collections.
     *
     * These are deliberately NOT written to the cache store. Eloquent
     * collections do not survive a serialize/unserialize round-trip through the
     * database cache driver -- they come back as __PHP_Incomplete_Class and
     * every property access fatals. Re-querying once per request is cheap;
     * debugging that is not.
     *
     * @var array<string, Collection<int, mixed>>
     */
    private array $memo = [];

    /**
     * The full settings map, loaded from cache or rebuilt from the database
     * layered on top of the defaults.
     *
     * @return array<string, array<string, mixed>>
     */
    public function settings(): array
    {
        if ($this->settings !== null) {
            return $this->settings;
        }

        return $this->settings = Cache::remember(
            config('site.cache.key'),
            config('site.cache.ttl'),
            static function (): array {
                $map = SettingsDefaults::all();

                foreach (Setting::query()->get(['group', 'key', 'value']) as $row) {
                    $map[$row->group][$row->key] = $row->value;
                }

                return $map;
            },
        );
    }

    /**
     * Read a setting by "group.key" dot notation.
     */
    public function setting(string $path, mixed $default = null): mixed
    {
        [$group, $key] = array_pad(explode('.', $path, 2), 2, null);

        if ($group === null || $key === null) {
            return $default;
        }

        return data_get($this->settings(), "{$group}.{$key}", $default);
    }

    /**
     * Read a bilingual setting: "contact.form_title" resolves to
     * contact.form_title_ar or contact.form_title_en for the active locale,
     * falling back to the other language when one side is blank.
     */
    public function text(string $path, string $default = ''): string
    {
        $locale   = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        $value = $this->setting("{$path}_{$locale}");

        if (blank($value)) {
            $value = $this->setting("{$path}_{$fallback}");
        }

        // Some keys (email, phone) are not bilingual at all -- try the bare key.
        if (blank($value)) {
            $value = $this->setting($path);
        }

        return blank($value) ? $default : (string) $value;
    }

    /**
     * A bilingual setting split into a list on newlines.
     *
     * @return array<int, string>
     */
    public function list(string $path): array
    {
        $value = $this->text($path);

        if (blank($value)) {
            return [];
        }

        return array_values(array_filter(
            array_map(trim(...), preg_split('/\r\n|\r|\n/', $value) ?: []),
            static fn (string $line): bool => $line !== '',
        ));
    }

    /**
     * A bilingual setting split into paragraphs on blank lines.
     *
     * @return array<int, string>
     */
    public function paragraphs(string $path): array
    {
        $value = $this->text($path);

        if (blank($value)) {
            return [];
        }

        return array_values(array_filter(
            array_map(trim(...), preg_split('/(\r\n|\r|\n){2,}/', $value) ?: []),
            static fn (string $para): bool => $para !== '',
        ));
    }

    /** @return Collection<int, Dish> */
    public function dishes(): Collection
    {
        return $this->remember('dishes', static fn () => Dish::query()->ordered()->get());
    }

    /** @return Collection<int, Dish> */
    public function featuredDishes(int $limit = 6): Collection
    {
        return $this->dishes()->where('is_featured', true)->take($limit);
    }

    /** @return Collection<int, Service> */
    public function services(): Collection
    {
        return $this->remember('services', static fn () => Service::query()->ordered()->get());
    }

    /** @return Collection<int, Experience> */
    public function experiences(): Collection
    {
        return $this->remember('experiences', static fn () => Experience::query()->ordered()->get());
    }

    /** @return Collection<int, EducationItem> */
    public function educationItems(): Collection
    {
        return $this->remember('education', static fn () => EducationItem::query()->ordered()->get());
    }

    /** @return Collection<int, Skill> */
    public function skills(): Collection
    {
        return $this->remember('skills', static fn () => Skill::query()->ordered()->get());
    }

    /** @return Collection<int, Metric> */
    public function metrics(): Collection
    {
        return $this->remember('metrics', static fn () => Metric::query()->ordered()->get());
    }

    /** @return Collection<int, ProcessStep> */
    public function processSteps(): Collection
    {
        return $this->remember('process', static fn () => ProcessStep::query()->ordered()->get());
    }

    /**
     * Dishes grouped by their localized category, preserving sort order.
     *
     * @return array<string, Collection<int, Dish>>
     */
    public function dishesByCategory(): array
    {
        return $this->dishes()
            ->groupBy(static fn (Dish $dish): string => $dish->localized('category'))
            ->all();
    }

    /**
     * Drop the persistent settings cache and the per-request memo. Called by
     * ContentObserver whenever anything editable is saved or deleted, so a
     * dashboard change is visible on the public site on the very next request.
     */
    public function flush(): void
    {
        Cache::forget(config('site.cache.key'));

        $this->settings = null;
        $this->memo     = [];
    }

    /**
     * @template TValue of Collection<int, mixed>
     *
     * @param  callable(): TValue  $resolver
     * @return TValue
     */
    private function remember(string $key, callable $resolver): Collection
    {
        return $this->memo[$key] ??= $resolver();
    }
}

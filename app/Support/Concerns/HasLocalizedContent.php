<?php

declare(strict_types=1);

namespace App\Support\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Gives a content model locale-aware accessors over its `{field}_ar` /
 * `{field}_en` column pairs.
 *
 * Every content table stores both languages side by side rather than in a
 * translations table, so a row is a complete, editable unit in the dashboard.
 */
trait HasLocalizedContent
{
    /**
     * Read `{field}_{locale}`, falling back to the other language when the
     * requested one is blank. A half-translated row degrades to showing
     * *something* rather than a hole in the page.
     */
    public function localized(string $field, ?string $locale = null): string
    {
        $locale   = $locale ?: app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        $value = $this->getAttribute("{$field}_{$locale}");

        if (blank($value)) {
            $value = $this->getAttribute("{$field}_{$fallback}");
        }

        if (blank($value)) {
            foreach (array_keys(config('locales.supported', [])) as $candidate) {
                $value = $this->getAttribute("{$field}_{$candidate}");

                if (filled($value)) {
                    break;
                }
            }
        }

        return (string) ($value ?? '');
    }

    /**
     * Same as localized(), for json array columns such as `features_ar`.
     *
     * @return array<int, string>
     */
    public function localizedArray(string $field, ?string $locale = null): array
    {
        $locale   = $locale ?: app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        $value = $this->getAttribute("{$field}_{$locale}");

        if (blank($value)) {
            $value = $this->getAttribute("{$field}_{$fallback}");
        }

        return array_values(array_filter(
            (array) ($value ?? []),
            static fn ($item): bool => filled($item),
        ));
    }

    /**
     * Content is hand-ordered in the dashboard, never sorted by id.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}

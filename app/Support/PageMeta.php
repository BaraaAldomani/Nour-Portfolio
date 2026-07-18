<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Contracts\Support\Arrayable;

/**
 * The per-page SEO payload.
 *
 * Resolution order for every field is settings-first, lang-file second: a title
 * set in the dashboard always wins, and the lang file only supplies a sensible
 * default for pages nobody has customised.
 *
 * @implements Arrayable<string, mixed>
 */
final readonly class PageMeta implements Arrayable
{
    public function __construct(
        public string $title,
        public string $description,
        public string $canonical,
        public string $image,
        public string $type = 'website',
    ) {}

    /**
     * Build the meta for a named page.
     *
     * @param  array<string, string>  $overrides
     */
    public static function for(string $page, array $overrides = []): self
    {
        $site = site();

        $siteName = $site->text('identity.name', config('app.name'));

        // A page-specific title from settings, else the lang file, else the
        // site-wide default.
        $title = $overrides['title']
            ?? self::firstFilled(
                $site->text("pages.{$page}_title"),
                self::trans("seo.{$page}.title"),
            );

        $description = $overrides['description']
            ?? self::firstFilled(
                $site->text("pages.{$page}_lead"),
                self::trans("seo.{$page}.description"),
                $site->text('seo.description'),
            );

        // The home page owns the brand title verbatim; inner pages are suffixed.
        $fullTitle = $page === 'home' || $title === ''
            ? self::firstFilled($site->text('seo.title'), $siteName)
            : "{$title} — {$siteName}";

        return new self(
            title: $fullTitle,
            description: $description,
            canonical: $overrides['canonical'] ?? url()->current(),
            image: $overrides['image'] ?? image_url((string) setting('images.og'), 'og'),
            type: $overrides['type'] ?? ($page === 'home' ? 'website' : 'article'),
        );
    }

    /**
     * The hreflang alternates for the current route, plus x-default pointing at
     * the site's default locale.
     *
     * @return array<string, string>
     */
    public static function alternates(): array
    {
        $alternates = [];

        foreach (array_keys(config('locales.supported', [])) as $locale) {
            $alternates[$locale] = locale_url($locale);
        }

        $alternates['x-default'] = $alternates[config('locales.default', 'ar')] ?? reset($alternates);

        return $alternates;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'canonical'   => $this->canonical,
            'image'       => $this->image,
            'type'        => $this->type,
        ];
    }

    private static function firstFilled(?string ...$values): string
    {
        foreach ($values as $value) {
            if (filled($value)) {
                return (string) $value;
            }
        }

        return '';
    }

    /**
     * Translate only when the key actually exists, so a missing key yields an
     * empty string rather than leaking "seo.about.title" into a meta tag.
     */
    private static function trans(string $key): string
    {
        return __($key) === $key ? '' : (string) __($key);
    }
}

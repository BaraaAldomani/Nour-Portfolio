@php
    use App\Support\PageMeta;
    use App\Support\SettingsDefaults;

    $locale     = app()->getLocale();
    $config     = config("locales.supported.{$locale}", []);
    $direction  = $config['direction'] ?? 'rtl';
    $alternates = PageMeta::alternates();

    $meta = $meta ?? PageMeta::for('home');

    // Fallbacks come from SettingsDefaults rather than being written out here,
    // so this template holds no colour of its own and there is exactly one
    // place the shipped brand palette is defined.
    $theme = SettingsDefaults::theme();
@endphp

<!DOCTYPE html>
<html lang="{{ $config['html_lang'] ?? $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $meta->title }}</title>
    <meta name="description" content="{{ $meta->description }}">
    <link rel="canonical" href="{{ $meta->canonical }}">

    {{-- hreflang alternates plus x-default, so each language is indexed as a
         translation rather than as duplicate content. --}}
    @foreach ($alternates as $key => $href)
        <link rel="alternate" hreflang="{{ $key }}" href="{{ $href }}">
    @endforeach

    {{-- Open Graph / Twitter --}}
    <meta property="og:type" content="{{ $meta->type }}">
    <meta property="og:site_name" content="{{ setting_text('identity.name') }}">
    <meta property="og:title" content="{{ $meta->title }}">
    <meta property="og:description" content="{{ $meta->description }}">
    <meta property="og:url" content="{{ $meta->canonical }}">
    <meta property="og:image" content="{{ $meta->image }}">
    <meta property="og:locale" content="{{ $config['iso'] ?? 'ar_SA' }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta->title }}">
    <meta name="twitter:description" content="{{ $meta->description }}">
    <meta name="twitter:image" content="{{ $meta->image }}">

    <meta name="theme-color" content="{{ setting('theme.brand_secondary', $theme['brand_secondary']) }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    {{--
    | Emits the @font-face rules and preload links for the four self-hosted
    | families built by the Vite fonts plugin. Without this the CSS still asks
    | for Amiri and Cormorant, but nothing ever defines them, so the whole site
    | silently falls back to the system serif and sans.
    --}}
    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{--
    | The three brand colours from the dashboard, injected AFTER @vite so they
    | win over the defaults in tokens.css. Every other colour on the site is a
    | live color-mix() of these, so this one block re-themes everything.
    --}}
    <style>
        :root {
            --brand-primary: {{ setting('theme.brand_primary', $theme['brand_primary']) }};
            --brand-secondary: {{ setting('theme.brand_secondary', $theme['brand_secondary']) }};
            --brand-accent: {{ setting('theme.brand_accent', $theme['brand_accent']) }};
        }
    </style>

    {{-- JSON-LD: a Person, which is what this site actually describes.
         Built in PHP rather than with @json -- the directive's argument parser
         cannot handle a multi-line array with nested arrays plus flags. --}}
    @php
        $jsonLd = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => setting_text('identity.name'),
            'jobTitle' => setting_text('identity.role'),
            'description' => setting_text('seo.description'),
            'image' => image_url((string) setting('images.portrait'), 'portrait'),
            'url' => route('home'),
            'email' => setting('contact.email'),
            'telephone' => setting('contact.phone'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Riyadh',
                'addressCountry' => 'SA',
            ],
            'knowsLanguage' => ['ar', 'en'],
            // One URL per line in the dashboard.
            'sameAs' => setting_list('seo.same_as'),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    @endphp
    <script type="application/ld+json">{!! $jsonLd !!}</script>
</head>
<body class="min-h-screen bg-surface text-ink antialiased">
    <a
        href="#main"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:z-100 focus:rounded-full
               focus:bg-primary focus:px-5 focus:py-2.5 focus:text-sm focus:text-on-primary"
        style="inset-inline-start: 1rem;"
    >
        {{ __('nav.skip') }}
    </a>

    <x-site-header />

    <main id="main">
        {{ $slot }}
    </main>

    <x-site-footer />
</body>
</html>

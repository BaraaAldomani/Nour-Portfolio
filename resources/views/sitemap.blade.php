{{--
| The XML declaration is assembled from fragments so the literal "<?" and "?>"
| sequences never appear in this file. Blade compiles templates through
| token_get_all(), which opens a PHP context at "<?" -- a literal declaration
| here is silently left uncompiled and then blows up as a parse error.
--}}
@php echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' @endphp
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="http://www.w3.org/1999/xhtml"
>
@foreach ($entries as $entry)
    <url>
        <loc>{{ $entry['loc'] }}</loc>
@foreach ($entry['alternates'] as $locale => $href)
        <xhtml:link rel="alternate" hreflang="{{ $locale }}" href="{{ $href }}"/>
@endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $entry['default'] }}"/>
        <changefreq>monthly</changefreq>
        <priority>{{ $entry['priority'] }}</priority>
    </url>
@endforeach
</urlset>

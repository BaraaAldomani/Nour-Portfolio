@props([
    'eyebrow' => null,
    'title' => null,
    'lead' => null,
    'align' => 'start',
])

<div @class([
    'max-w-3xl',
    'mx-auto text-center' => $align === 'center',
])>
    @if ($eyebrow)
        <p class="eyebrow reveal">{{ $eyebrow }}</p>
    @endif

    @if ($title)
        <h2 class="display-section reveal mt-4 text-ink" data-reveal-index="1">{{ $title }}</h2>
    @endif

    @if ($lead)
        <p class="lead reveal mt-6" data-reveal-index="2">{{ $lead }}</p>
    @endif

    {{ $slot }}
</div>

@props([
    'dish',
    'index' => 0,
    'aspect' => 'aspect-[4/3]',
])

<article
    data-category="{{ $dish->localized('category') }}"
    data-reveal-index="{{ $index }}"
    class="reveal group"
>
    <div class="frame {{ $aspect }}">
        <img
            src="{{ $dish->imageUrl() }}"
            alt="{{ __('common.dish_alt', ['title' => $dish->localized('title')]) }}"
            loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
            decoding="async"
            width="1080"
            height="810"
        />

        {{-- Bottom scrim so the caption stays legible over any photograph. --}}
        <div
            class="pointer-events-none absolute inset-0 bg-gradient-to-t from-neutral-950/85 via-neutral-950/10 to-transparent
                   opacity-80 transition-opacity duration-500 group-hover:opacity-95"
        ></div>

        <div class="absolute inset-inline-0 bottom-0 p-5" style="inset-inline: 0;">
            <p class="text-[0.6875rem] tracking-[0.16em] text-primary uppercase">
                {{ $dish->localized('category') }}
            </p>
            <h3 class="mt-1.5 font-display text-2xl text-neutral-100">
                {{ $dish->localized('title') }}
            </h3>
        </div>
    </div>

    @if ($dish->localized('description'))
        <p class="mt-4 text-sm leading-relaxed text-muted">
            {{ $dish->localized('description') }}
        </p>
    @endif
</article>

@props([
    'opacity' => '0.5',
])

{{--
| The signature motif: concentric dashed rings, turning slowly in opposite
| directions, like the rim of a plate under a pass lamp.
|
| Purely decorative -- aria-hidden, and stilled entirely by
| prefers-reduced-motion (see app.css).
--}}
<div {{ $attributes->merge(['class' => 'plate-ring']) }} aria-hidden="true">
    <svg viewBox="0 0 400 400" class="h-full w-full" fill="none" style="opacity: {{ $opacity }}">
        <circle
            cx="200" cy="200" r="196"
            stroke="currentColor" stroke-width="0.8"
            stroke-dasharray="1 9" stroke-linecap="round"
            class="plate-ring__spin"
        />
        <circle
            cx="200" cy="200" r="170"
            stroke="currentColor" stroke-width="0.6"
            stroke-dasharray="3 14"
            class="plate-ring__spin plate-ring__spin--reverse"
        />
        <circle cx="200" cy="200" r="150" stroke="currentColor" stroke-width="0.5" opacity="0.55" />
        <circle
            cx="200" cy="200" r="122"
            stroke="currentColor" stroke-width="0.8"
            stroke-dasharray="1 7" stroke-linecap="round"
            class="plate-ring__spin"
        />
    </svg>
</div>

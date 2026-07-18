@props(['name' => 'knife'])

{{--
| The service icons. Hand-drawn as a small set rather than pulled from an icon
| package, so they share one stroke weight and one visual language with the
| logo -- and so the site gains no runtime dependency.
--}}
@php
    $paths = [
        // Menu / clipboard with lines
        'menu' => [
            'M7 4h10a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z',
            'M9 3h6v3H9z',
            'M8.5 11h7', 'M8.5 15h4',
        ],
        // Brigade / people
        'brigade' => [
            'M9 11a3.2 3.2 0 1 0 0-6.4A3.2 3.2 0 0 0 9 11Z',
            'M3.5 20a5.5 5.5 0 0 1 11 0',
            'M16 11.5a2.6 2.6 0 1 0 0-5.2',
            'M16.5 14.4A4.6 4.6 0 0 1 20.5 19',
        ],
        // Flame
        'flame' => [
            'M12 3c2.6 3.2 5.4 5.2 5.4 9a5.4 5.4 0 1 1-10.8 0c0-1.6.7-2.9 1.7-4 .3 1 .9 1.7 1.7 2 .1-2.9 1-5.2 2-7Z',
        ],
        // Leaf
        'leaf' => [
            'M4.5 19.5C4.5 11.5 10 6 19.5 5.5c.5 8.5-4.5 14-15 14Z',
            'M4.5 19.5C8 16 11 13.5 15.5 11.5',
        ],
        // Shield
        'shield' => [
            'M12 3.2 19 6v5.5c0 4.4-2.9 7.6-7 9.3-4.1-1.7-7-4.9-7-9.3V6l7-2.8Z',
            'M9 12.2l2.1 2.1L15.2 10',
        ],
        // Scale / balance
        'scale' => [
            'M12 4v16', 'M7 20h10',
            'M4 8h16', 'M12 8 8.2 8', 'M12 8 15.8 8',
            'M4 8 1.8 13.2a3 3 0 0 0 4.4 0L4 8Z',
            'M20 8l-2.2 5.2a3 3 0 0 0 4.4 0L20 8Z',
        ],
        // Knife (default)
        'knife' => [
            'M4 16.5 15.5 4l3 3L7 19.5Z',
            'M5.5 18 3 20.5',
        ],
    ];

    $shape = $paths[$name] ?? $paths['knife'];
@endphp

<svg
    {{ $attributes->merge(['class' => 'h-6 w-6']) }}
    viewBox="0 0 24 24" fill="none"
    stroke="currentColor" stroke-width="1.4"
    stroke-linecap="round" stroke-linejoin="round"
    aria-hidden="true" focusable="false"
>
    @foreach ($shape as $d)
        <path d="{{ $d }}" />
    @endforeach
</svg>

@props([
    'animated' => false,
    'title' => null,
])

{{--
| The monogram: an N whose diagonal is a knife blade, under a chef's toque,
| inside the dashed plate ring that recurs across the whole site.
|
| Drawn with currentColor so it inherits whatever text colour it sits in, and
| stays correct in both the dark and light registers without a second asset.
--}}
<svg
    {{ $attributes->merge(['class' => 'block', 'viewBox' => '0 0 64 64']) }}
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    @if ($title)
        role="img" aria-label="{{ $title }}"
    @else
        aria-hidden="true" focusable="false"
    @endif
>
    {{-- Outer dashed plate rim. --}}
    <circle
        cx="32" cy="32" r="30.2"
        stroke="currentColor" stroke-width="0.9"
        stroke-dasharray="2 6" stroke-linecap="round"
        opacity="0.5"
        @class(['plate-ring__spin' => $animated])
    />

    {{-- Inner rim. --}}
    <circle cx="32" cy="32" r="25.4" stroke="currentColor" stroke-width="1" opacity="0.85" />

    {{-- Toque: three bumps over a band. --}}
    <path
        d="M23.6 25.4C23.6 21.9 25.8 19.7 28.2 20.4C29.1 17.7 34.9 17.7 35.8 20.4C38.2 19.7 40.4 21.9 40.4 25.4"
        stroke="currentColor" stroke-width="1.5"
        stroke-linecap="round" stroke-linejoin="round"
        opacity="0.75"
    />
    <path d="M23.6 25.4H40.4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.75" />

    {{-- N: two stems. --}}
    <path d="M23.6 45.4V30.2" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" />
    <path d="M40.4 45.4V30.2" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" />

    {{-- N: the diagonal, tapered into a blade that comes to a point. --}}
    <path d="M23.6 30.4L27.1 30.4L41 45.6L40 46.4Z" fill="currentColor" />
</svg>

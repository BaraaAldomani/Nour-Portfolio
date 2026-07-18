@props([
    'eyebrow' => null,
    'title' => null,
    'lead' => null,
])

{{-- The shared inner-page masthead. Copy comes from the "pages" settings group. --}}
<section class="relative overflow-hidden border-b border-line pt-36 pb-16 lg:pt-44 lg:pb-24">
    {{-- Offset toward the trailing edge with a logical inset, so it sits on the
         far side of the reading direction in both languages. --}}
    <x-plate-rings class="top-0 h-[34rem] w-[34rem] -translate-y-1/3" style="inset-inline-end: -8rem; inset-inline-start: auto;" opacity="0.2" />

    <div class="container-page relative">
        @if ($eyebrow)
            <p class="eyebrow reveal flex items-center gap-3">
                <span class="h-px w-10 bg-primary"></span>
                {{ $eyebrow }}
            </p>
        @endif

        <h1 class="display-hero reveal mt-5 max-w-4xl text-ink" data-reveal-index="1">
            {{ $title }}
        </h1>

        @if ($lead)
            <p class="lead reveal mt-7 max-w-2xl" data-reveal-index="2">{{ $lead }}</p>
        @endif
    </div>
</section>

<x-layouts.app :meta="$meta">

    {{-- ================================================================== --}}
    {{-- Hero                                                                --}}
    {{-- ================================================================== --}}
    <section class="relative overflow-hidden pt-32 pb-20 lg:pt-40 lg:pb-28">
        <div class="container-page relative grid items-center gap-14 lg:grid-cols-[1.05fr_0.95fr]">
            {{-- Copy --}}
            <div>
                <p class="eyebrow reveal">{{ setting_text('home.hero_eyebrow') }}</p>

                <h1 class="display-hero reveal mt-6 text-ink" data-reveal-index="1">
                    {{ setting_text('identity.name') }}
                </h1>

                <div class="reveal mt-6 flex items-center gap-4" data-reveal-index="2">
                    <span class="h-px w-14 bg-primary"></span>
                    <p class="font-display text-2xl text-primary lg:text-3xl">
                        {{ setting_text('identity.tagline') }}
                    </p>
                </div>

                <p class="lead reveal mt-8 max-w-xl" data-reveal-index="3">
                    {{ setting_text('home.hero_lead') }}
                </p>

                <div class="reveal mt-10 flex flex-wrap items-center gap-4" data-reveal-index="4">
                    <a href="{{ route('portfolio') }}" class="btn btn-primary">
                        {{ setting_text('home.hero_cta') }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-ghost">
                        {{ setting_text('home.hero_cta_alt') }}
                    </a>
                </div>
            </div>

            {{-- Portrait, with the pass lamp and the plate rings behind it.
                 Both decorations are centred on the portrait itself, so they
                 track it in either writing direction. --}}
            <div class="reveal-blur relative mx-auto w-full max-w-md lg:max-w-none">
                <div class="pass-glow center-abs h-[34rem] w-[34rem] opacity-70" aria-hidden="true"></div>
                <x-plate-rings class="center-abs h-[42rem] w-[42rem]" opacity="0.32" />

                <img
                    src="{{ image_url((string) setting('images.portrait'), 'portrait') }}"
                    alt="{{ __('common.portrait_alt') }}"
                    class="relative w-full select-none drop-shadow-[0_30px_60px_var(--glow-primary)]"
                    width="1280"
                    height="1280"
                    fetchpriority="high"
                    decoding="async"
                >
            </div>
        </div>

        {{-- Metrics --}}
        @if ($site->metrics()->isNotEmpty())
            <div class="container-page relative mt-20 lg:mt-28">
                <dl class="grid grid-cols-2 gap-px overflow-hidden border border-line bg-line lg:grid-cols-4">
                    @foreach ($site->metrics() as $index => $metric)
                        {{-- column-reverse puts the figure above its label while
                             keeping the required dt-then-dd source order. --}}
                        <div
                            class="reveal flex flex-col-reverse bg-surface p-7 text-center lg:p-9"
                            data-reveal-index="{{ $index }}"
                        >
                            <dt class="mt-3 text-sm leading-snug text-muted">
                                {{ $metric->localized('label') }}
                            </dt>
                            <dd class="font-display text-5xl text-primary lg:text-6xl">
                                <span data-count-to="{{ $metric->value }}">{{ $metric->value }}</span
                                >@if ($metric->suffix)<span>{{ $metric->suffix }}</span>@endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        @endif
    </section>

    {{-- ================================================================== --}}
    {{-- The principle -- a light section for contrast                       --}}
    {{-- ================================================================== --}}
    <section class="surface-light relative overflow-hidden bg-surface py-24 lg:py-32">
        <div class="container-page relative grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:gap-20">
            <div>
                <p class="eyebrow reveal">{{ setting_text('home.intro_eyebrow') }}</p>
                <div class="rule reveal mt-8 w-24" data-reveal-index="1"></div>
            </div>

            <div>
                <h2 class="display-section reveal text-ink">
                    {{ setting_text('home.intro_title') }}
                </h2>
                <p class="lead reveal mt-8" data-reveal-index="1">
                    {{ setting_text('home.intro_body') }}
                </p>
            </div>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- Selected dishes                                                     --}}
    {{-- ================================================================== --}}
    @if ($site->featuredDishes()->isNotEmpty())
        <section class="py-24 lg:py-32">
            <div class="container-page">
                <div class="flex flex-wrap items-end justify-between gap-8">
                    <x-section-heading
                        :eyebrow="setting_text('home.portfolio_eyebrow')"
                        :title="setting_text('home.portfolio_title')"
                    />

                    <a href="{{ route('portfolio') }}" class="link-underline reveal text-sm">
                        {{ setting_text('home.portfolio_cta') }}
                    </a>
                </div>

                <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($site->featuredDishes() as $index => $dish)
                        <x-dish-card :dish="$dish" :index="$index" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================== --}}
    {{-- Services                                                            --}}
    {{-- ================================================================== --}}
    @if ($site->services()->isNotEmpty())
        <section class="surface-light bg-surface py-24 lg:py-32">
            <div class="container-page">
                <x-section-heading
                    :eyebrow="setting_text('home.services_eyebrow')"
                    :title="setting_text('home.services_title')"
                />

                <div class="mt-14 grid gap-px overflow-hidden border border-line bg-line sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($site->services() as $index => $service)
                        <article class="reveal bg-surface p-8 lg:p-10" data-reveal-index="{{ $index }}">
                            <x-service-icon :name="$service->icon" class="h-7 w-7 text-primary" />
                            <h3 class="mt-6 font-display text-2xl text-ink">{{ $service->localized('title') }}</h3>
                            <p class="mt-3 text-sm leading-relaxed text-muted">{{ $service->localized('summary') }}</p>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12">
                    <a href="{{ route('services') }}" class="link-underline reveal text-sm">
                        {{ __('common.view_all') }}
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================== --}}
    {{-- Method                                                              --}}
    {{-- ================================================================== --}}
    @if ($site->processSteps()->isNotEmpty())
        <section class="relative overflow-hidden py-24 lg:py-32">
            <x-plate-rings class="top-1/2 h-[40rem] w-[40rem] -translate-y-1/2" style="inset-inline-start: -14rem;" opacity="0.16" />

            <div class="container-page relative">
                <x-section-heading
                    :eyebrow="setting_text('home.process_eyebrow')"
                    :title="setting_text('home.process_title')"
                />

                <ol class="mt-16 grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($site->processSteps() as $index => $step)
                        <li class="reveal" data-reveal-index="{{ $index }}">
                            <div class="flex items-baseline gap-4">
                                <span class="font-display text-5xl text-primary/45">
                                    {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="h-px flex-1 bg-line"></span>
                            </div>
                            <h3 class="mt-5 font-display text-2xl text-ink">{{ $step->localized('title') }}</h3>
                            <p class="mt-3 text-sm leading-relaxed text-muted">{{ $step->localized('description') }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    {{-- ================================================================== --}}
    {{-- Experience preview                                                  --}}
    {{-- ================================================================== --}}
    @if ($site->experiences()->isNotEmpty())
        <section class="border-t border-line py-24 lg:py-32">
            <div class="container-page">
                <div class="flex flex-wrap items-end justify-between gap-8">
                    <x-section-heading
                        :eyebrow="setting_text('home.experience_eyebrow')"
                        :title="setting_text('home.experience_title')"
                    />

                    <a href="{{ route('experience') }}" class="link-underline reveal text-sm">
                        {{ setting_text('home.experience_cta') }}
                    </a>
                </div>

                <ul class="mt-14">
                    @foreach ($site->experiences() as $index => $experience)
                        <li
                            class="reveal grid gap-3 border-t border-line py-8 last:border-b sm:grid-cols-[10rem_1fr_auto] sm:items-baseline sm:gap-8"
                            data-reveal-index="{{ $index }}"
                        >
                            <span class="font-mono text-sm text-faint" dir="ltr">{{ $experience->period() }}</span>
                            <div>
                                <h3 class="font-display text-2xl text-ink">{{ $experience->localized('company') }}</h3>
                                <p class="mt-1 text-sm text-muted">{{ $experience->localized('role') }}</p>
                            </div>
                            @if ($experience->is_current)
                                <span class="justify-self-start rounded-full border border-primary/45 px-3 py-1 text-xs text-primary sm:justify-self-end">
                                    {{ __('common.present') }}
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    {{-- ================================================================== --}}
    {{-- Closing call to action                                              --}}
    {{-- ================================================================== --}}
    <section class="relative overflow-hidden border-t border-line py-24 lg:py-32">
        <div class="pass-glow center-abs h-[32rem] w-[32rem] opacity-45" aria-hidden="true"></div>
        <x-plate-rings class="center-abs h-[38rem] w-[38rem]" opacity="0.3" />

        <div class="container-page relative text-center">
            <x-logo class="reveal mx-auto h-16 w-16 text-primary" :animated="true" />

            <h2 class="display-section reveal mx-auto mt-8 max-w-2xl text-ink" data-reveal-index="1">
                {{ setting_text('home.cta_title') }}
            </h2>

            <p class="lead reveal mx-auto mt-6 max-w-xl" data-reveal-index="2">
                {{ setting_text('home.cta_body') }}
            </p>

            <div class="reveal mt-10" data-reveal-index="3">
                <a href="{{ route('contact') }}" class="btn btn-primary">
                    {{ setting_text('home.cta_button') }}
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>

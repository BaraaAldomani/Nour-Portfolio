<x-layouts.app :meta="$meta">

    <x-page-header
        :eyebrow="setting_text('pages.about_eyebrow')"
        :title="setting_text('pages.about_title')"
        :lead="setting_text('pages.about_lead')"
    />

    {{-- Story + portrait --}}
    <section class="py-20 lg:py-28">
        <div class="container-page grid gap-14 lg:grid-cols-[1.15fr_0.85fr] lg:gap-20">
            <div>
                <h2 class="display-section reveal text-ink">{{ setting_text('about.story_title') }}</h2>

                <div class="mt-8 space-y-5">
                    @foreach ($site->paragraphs('about.story_body') as $index => $paragraph)
                        <p class="reveal text-base leading-relaxed text-muted lg:text-lg" data-reveal-index="{{ $index + 1 }}">
                            {{ $paragraph }}
                        </p>
                    @endforeach
                </div>

                <h2 class="display-section reveal mt-16 text-ink">{{ setting_text('about.philosophy_title') }}</h2>
                <p class="reveal mt-8 text-base leading-relaxed text-muted lg:text-lg" data-reveal-index="1">
                    {{ setting_text('about.philosophy_body') }}
                </p>
            </div>

            <div class="relative">
                <div class="pass-glow center-abs h-[26rem] w-[26rem] opacity-55" aria-hidden="true"></div>
                <x-plate-rings class="center-abs h-[30rem] w-[30rem]" opacity="0.28" />

                <img
                    src="{{ image_url((string) setting('images.portrait'), 'portrait') }}"
                    alt="{{ __('common.portrait_alt') }}"
                    class="reveal-blur relative mx-auto w-full max-w-sm lg:sticky lg:top-28"
                    width="1280" height="1280" loading="lazy" decoding="async"
                >
            </div>
        </div>
    </section>

    {{-- Skills --}}
    @if ($site->skills()->isNotEmpty())
        <section class="surface-light bg-surface py-20 lg:py-28">
            <div class="container-page">
                <h2 class="display-section reveal text-ink">{{ setting_text('about.skills_title') }}</h2>

                <div class="mt-12 grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($site->skills()->groupBy(fn ($skill) => $skill->category->value) as $category => $skills)
                        <div class="reveal" data-reveal-index="{{ $loop->index }}">
                            <h3 class="text-xs font-medium uppercase tracking-[0.2em] text-primary">
                                {{ $skills->first()->category->label() }}
                            </h3>

                            <ul class="mt-6 space-y-4">
                                @foreach ($skills as $skill)
                                    <li>
                                        <p class="text-sm text-ink">{{ $skill->localized('name') }}</p>
                                        <p class="meter mt-2" role="img"
                                           aria-label="{{ $skill->localized('name') }}: {{ $skill->level }}/5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span data-on="{{ $i <= $skill->level ? '1' : '0' }}"></span>
                                            @endfor
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Education + languages --}}
    <section class="py-20 lg:py-28">
        <div class="container-page grid gap-16 lg:grid-cols-[1.2fr_0.8fr] lg:gap-24">
            @if ($site->educationItems()->isNotEmpty())
                <div>
                    <h2 class="display-section reveal text-ink">{{ setting_text('about.education_title') }}</h2>

                    <ul class="mt-10">
                        @foreach ($site->educationItems() as $index => $item)
                            <li class="reveal border-t border-line py-7 last:border-b" data-reveal-index="{{ $index }}">
                                <div class="flex flex-wrap items-baseline justify-between gap-3">
                                    <h3 class="font-display text-2xl text-ink">
                                        {{ $item->localized('credential') }} — {{ $item->localized('field') }}
                                    </h3>
                                    <span class="font-mono text-sm text-faint" dir="ltr">{{ $item->completedLabel() }}</span>
                                </div>
                                <p class="mt-2 text-sm text-muted">{{ $item->localized('institution') }}</p>
                                @if ($item->localized('grade'))
                                    <p class="mt-1 text-sm text-faint">{{ $item->localized('grade') }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <h2 class="display-section reveal text-ink">{{ setting_text('about.languages_title') }}</h2>
                <p class="reveal mt-8 text-base leading-relaxed text-muted" data-reveal-index="1">
                    {{ setting_text('about.languages_body') }}
                </p>

                <div class="reveal mt-12" data-reveal-index="2">
                    <a href="{{ route('contact') }}" class="btn btn-primary">
                        {{ setting_text('home.cta_button') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>

<x-layouts.app :meta="$meta">

    <x-page-header
        :eyebrow="setting_text('pages.experience_eyebrow')"
        :title="setting_text('pages.experience_title')"
        :lead="setting_text('pages.experience_lead')"
    />

    <section class="py-16 lg:py-24">
        <div class="container-page">
            <ol class="relative">
                {{-- The timeline spine. Positioned with a logical offset so it
                     sits on the reading edge in both directions. --}}
                <div
                    class="pointer-events-none absolute top-2 bottom-2 hidden w-px bg-line lg:block"
                    style="inset-inline-start: 11.5rem;"
                    aria-hidden="true"
                ></div>

                @foreach ($site->experiences() as $index => $experience)
                    <li class="reveal relative pb-16 last:pb-0" data-reveal-index="{{ $index }}">
                        <div class="grid gap-6 lg:grid-cols-[10rem_1fr] lg:gap-16">
                            {{-- Dates --}}
                            <div class="lg:text-end">
                                <p class="font-mono text-sm text-primary" dir="ltr">{{ $experience->period() }}</p>
                                @if ($experience->localized('location'))
                                    <p class="mt-2 text-xs text-faint">{{ $experience->localized('location') }}</p>
                                @endif
                            </div>

                            {{-- Body --}}
                            <div class="relative">
                                {{-- Timeline node --}}
                                <span
                                    class="absolute top-3 hidden h-2.5 w-2.5 rounded-full border border-primary bg-surface lg:block"
                                    style="inset-inline-start: -4.3rem;"
                                    aria-hidden="true"
                                ></span>

                                <div class="flex flex-wrap items-baseline gap-x-4 gap-y-2">
                                    <h2 class="display-section text-ink">{{ $experience->localized('company') }}</h2>
                                    @if ($experience->is_current)
                                        <span class="rounded-full border border-primary/45 px-3 py-1 text-xs text-primary">
                                            {{ __('common.present') }}
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-2 text-lg text-primary">{{ $experience->localized('role') }}</p>

                                @if ($experience->localized('summary'))
                                    <p class="mt-5 max-w-2xl leading-relaxed text-muted">
                                        {{ $experience->localized('summary') }}
                                    </p>
                                @endif

                                @if ($experience->highlights())
                                    <ul class="mt-7 grid max-w-3xl gap-3 sm:grid-cols-2">
                                        @foreach ($experience->highlights() as $highlight)
                                            <li class="flex gap-3 text-sm leading-relaxed text-muted">
                                                <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-primary" aria-hidden="true"></span>
                                                <span>{{ $highlight }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Education --}}
    @if ($site->educationItems()->isNotEmpty())
        <section class="surface-light bg-surface py-20 lg:py-28">
            <div class="container-page">
                <h2 class="display-section reveal text-ink">{{ setting_text('about.education_title') }}</h2>

                <ul class="mt-10 grid gap-px overflow-hidden border border-line bg-line sm:grid-cols-2">
                    @foreach ($site->educationItems() as $index => $item)
                        <li class="reveal bg-surface p-8 lg:p-10" data-reveal-index="{{ $index }}">
                            <span class="font-mono text-sm text-faint" dir="ltr">{{ $item->completedLabel() }}</span>
                            <h3 class="mt-4 font-display text-2xl text-ink">
                                {{ $item->localized('credential') }} — {{ $item->localized('field') }}
                            </h3>
                            <p class="mt-2 text-sm text-muted">{{ $item->localized('institution') }}</p>
                            @if ($item->localized('grade'))
                                <p class="mt-1 text-sm text-faint">{{ $item->localized('grade') }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

</x-layouts.app>

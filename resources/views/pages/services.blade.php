<x-layouts.app :meta="$meta">

    <x-page-header
        :eyebrow="setting_text('pages.services_eyebrow')"
        :title="setting_text('pages.services_title')"
        :lead="setting_text('pages.services_lead')"
    />

    <section class="py-16 lg:py-24">
        <div class="container-page space-y-px">
            @foreach ($site->services() as $index => $service)
                <article
                    class="reveal-side grid gap-8 border-t border-line py-12 last:border-b lg:grid-cols-[4rem_1fr_1fr] lg:gap-16 lg:py-16"
                    data-reveal-index="{{ $index }}"
                >
                    <div>
                        <x-service-icon :name="$service->icon" class="icon-draw h-8 w-8 text-primary" />
                        <p class="mt-4 font-mono text-xs text-faint">
                            {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>

                    <div>
                        <h2 class="display-section text-ink">{{ $service->localized('title') }}</h2>
                        <p class="mt-5 leading-relaxed text-muted">{{ $service->localized('description') }}</p>
                    </div>

                    @if ($service->features())
                        <ul class="space-y-3 lg:pt-3">
                            @foreach ($service->features() as $feature)
                                <li class="flex gap-3 border-b border-line pb-3 text-sm text-muted last:border-0">
                                    <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-primary" aria-hidden="true"></span>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    {{-- Method --}}
    @if ($site->processSteps()->isNotEmpty())
        <section class="relative overflow-hidden border-t border-line bg-surface-2 py-20 lg:py-28">
            <div class="container-page relative">
                <x-section-heading
                    :eyebrow="setting_text('home.process_eyebrow')"
                    :title="setting_text('home.process_title')"
                />

                <ol class="mt-14 grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($site->processSteps() as $index => $step)
                        <li class="reveal-stagger" data-reveal-index="{{ $index }}">
                            <div class="flex items-baseline gap-4">
                                <span class="step-num font-display text-5xl text-primary/50">
                                    {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="step-rule h-px flex-1 bg-line-strong"></span>
                            </div>
                            <h3 class="step-title mt-5 font-display text-2xl text-ink">{{ $step->localized('title') }}</h3>
                            <p class="step-body mt-3 text-sm leading-relaxed text-muted">{{ $step->localized('description') }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    {{-- Closing CTA --}}
    <section class="relative overflow-hidden py-24 lg:py-32">
        <div class="pass-glow center-abs h-[30rem] w-[30rem] opacity-45" aria-hidden="true"></div>
        <x-plate-rings class="center-abs h-[36rem] w-[36rem]" opacity="0.26" />

        <div class="container-page relative text-center">
            <h2 class="display-section reveal mx-auto max-w-2xl text-ink">{{ setting_text('home.cta_title') }}</h2>
            <p class="lead reveal mx-auto mt-6 max-w-xl" data-reveal-index="1">{{ setting_text('home.cta_body') }}</p>
            <div class="reveal mt-10" data-reveal-index="2">
                <a href="{{ route('contact') }}" class="btn btn-primary">{{ setting_text('home.cta_button') }}</a>
            </div>
        </div>
    </section>

</x-layouts.app>

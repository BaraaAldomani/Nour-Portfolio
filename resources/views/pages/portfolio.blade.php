<x-layouts.app :meta="$meta">

    <x-page-header
        :eyebrow="setting_text('pages.portfolio_eyebrow')"
        :title="setting_text('pages.portfolio_title')"
        :lead="setting_text('pages.portfolio_lead')"
    />

    <section class="py-16 lg:py-24">
        <div class="container-page">
            @php $categories = $site->dishes()->pluck('category_'.app()->getLocale())->unique()->values(); @endphp

            {{--
            | Category filter. Progressive enhancement: without JavaScript no
            | button does anything, but every dish is already visible, so the
            | page is complete either way.
            --}}
            @if ($categories->count() > 1)
                <div class="flex flex-wrap gap-3" role="group" aria-label="{{ __('common.filter_by') }}">
                    <button
                        type="button" data-filter="all" aria-pressed="true" class="chip"
                    >
                        {{ __('common.all') }}
                    </button>

                    @foreach ($categories as $category)
                        <button
                            type="button" data-filter="{{ $category }}" aria-pressed="false"
                            class="chip"
                        >
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($site->dishes() as $index => $dish)
                    <x-dish-card :dish="$dish" :index="$index" />
                @endforeach
            </div>

            <div class="mt-16 flex flex-wrap items-center justify-between gap-6 border-t border-line pt-10">
                <p class="reveal max-w-xl text-sm text-muted">{{ setting_text('portfolio.note') }}</p>

                @if (setting('portfolio.pinterest_url'))
                    <a
                        href="{{ setting('portfolio.pinterest_url') }}"
                        target="_blank" rel="noopener noreferrer"
                        class="link-underline reveal text-sm"
                    >
                        {{ setting_text('portfolio.pinterest_label') }}
                    </a>
                @endif
            </div>
        </div>
    </section>

</x-layouts.app>

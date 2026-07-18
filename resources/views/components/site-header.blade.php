@php
    $links = [
        'home'       => route('home'),
        'about'      => route('about'),
        'portfolio'  => route('portfolio'),
        'experience' => route('experience'),
        'services'   => route('services'),
        'contact'    => route('contact'),
    ];

    $other = app()->getLocale() === 'ar' ? 'en' : 'ar';
@endphp

<header
    data-header
    class="fixed inset-inline-0 top-0 z-50 transition-colors duration-300
           data-scrolled:border-b data-scrolled:border-line data-scrolled:bg-glass
           data-scrolled:backdrop-blur-xl"
    style="inset-inline: 0;"
>
    <div class="container-page flex h-20 items-center justify-between gap-6">
        {{-- Brand --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 group" aria-label="{{ __('nav.brand_home') }}">
            <x-logo class="h-10 w-10 text-primary transition-transform duration-500 group-hover:rotate-[8deg]" :animated="true" />
            <span class="hidden sm:flex flex-col leading-tight">
                <span class="font-display text-lg text-ink">{{ setting_text('identity.name') }}</span>
                <span class="text-[0.6875rem] tracking-[0.18em] text-muted uppercase">
                    {{ setting_text('identity.role') }}
                </span>
            </span>
        </a>

        {{-- Desktop navigation --}}
        <nav class="hidden lg:flex items-center gap-8" aria-label="{{ __('nav.menu') }}">
            @foreach ($links as $key => $href)
                @php $isCurrent = url()->current() === $href; @endphp
                <a
                    href="{{ $href }}"
                    @if ($isCurrent) aria-current="page" @endif
                    @class([
                        'text-sm transition-colors duration-200 hover:text-primary',
                        'text-primary' => $isCurrent,
                        'text-muted' => ! $isCurrent,
                    ])
                >
                    {{ __("nav.{$key}") }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            {{-- Language switch --}}
            <a
                href="{{ locale_url($other) }}"
                hreflang="{{ $other }}"
                lang="{{ $other }}"
                aria-label="{{ __('nav.switch_lang') }}"
                class="rounded-full border border-control-line px-3.5 py-1.5 text-xs font-medium tracking-widest
                       text-muted transition-colors duration-200 hover:border-primary hover:text-primary"
            >
                {{ __('nav.lang_short') }}
            </a>

            {{-- Mobile toggle --}}
            <button
                type="button"
                data-nav-toggle
                aria-expanded="false"
                aria-controls="site-nav-panel"
                aria-label="{{ __('nav.open_menu') }}"
                class="lg:hidden rounded-full border border-control-line p-2.5 text-ink transition-colors hover:border-primary hover:text-primary"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile panel. `hidden` by default so it is closed without JS too. --}}
    <div
        id="site-nav-panel"
        data-nav-panel
        hidden
        class="lg:hidden border-t border-line bg-surface"
    >
        <nav class="container-page flex flex-col py-6" aria-label="{{ __('nav.menu') }}">
            @foreach ($links as $key => $href)
                <a
                    href="{{ $href }}"
                    @if (url()->current() === $href) aria-current="page" @endif
                    class="border-b border-line py-4 font-display text-2xl text-ink last:border-0 hover:text-primary"
                >
                    {{ __("nav.{$key}") }}
                </a>
            @endforeach
        </nav>
    </div>
</header>

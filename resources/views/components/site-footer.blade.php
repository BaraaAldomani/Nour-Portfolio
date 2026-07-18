@php
    $links = ['about', 'portfolio', 'experience', 'services', 'contact'];
    $email = (string) setting('contact.email');
    $phone = (string) setting('contact.phone');
@endphp

<footer class="relative overflow-hidden border-t border-line bg-surface">
    <x-plate-rings class="center-abs-top h-[42rem] w-[42rem]" opacity="0.14" />

    <div class="container-page relative py-16 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1.5fr_1fr_1fr]">
            {{-- Identity --}}
            <div>
                <div class="flex items-center gap-3">
                    <x-logo class="h-11 w-11 text-primary" />
                    <div>
                        <p class="font-display text-xl text-ink">{{ setting_text('identity.name') }}</p>
                        <p class="text-sm text-muted">{{ setting_text('identity.role') }}</p>
                    </div>
                </div>
                <p class="mt-5 max-w-sm text-sm leading-relaxed text-muted">
                    {{ setting_text('identity.tagline') }} · {{ setting_text('identity.location') }}
                </p>
            </div>

            {{-- Navigation --}}
            <nav aria-label="{{ __('nav.menu') }}">
                <h2 class="text-xs font-medium uppercase tracking-[0.2em] text-faint">{{ __('nav.menu') }}</h2>
                <ul class="mt-5 space-y-3">
                    @foreach ($links as $key)
                        <li>
                            <a href="{{ route($key) }}" class="text-sm text-muted transition-colors hover:text-primary">
                                {{ __("nav.{$key}") }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            {{-- Contact --}}
            <div>
                <h2 class="text-xs font-medium uppercase tracking-[0.2em] text-faint">{{ __('nav.contact') }}</h2>
                <ul class="mt-5 space-y-3 text-sm">
                    @if ($email)
                        <li>
                            <a href="mailto:{{ $email }}" class="text-muted transition-colors hover:text-primary" dir="ltr">
                                {{ $email }}
                            </a>
                        </li>
                    @endif
                    @if ($phone)
                        <li>
                            <a href="tel:{{ $phone }}" class="text-muted transition-colors hover:text-primary" dir="ltr">
                                {{ $phone }}
                            </a>
                        </li>
                    @endif
                    <li class="text-muted">{{ setting_text('contact.city') }}</li>
                </ul>
            </div>
        </div>

        <div class="mt-14 flex flex-col gap-3 border-t border-line pt-7 text-xs text-faint sm:flex-row sm:items-center sm:justify-between">
            <p>© {{ now()->year }} {{ setting_text('identity.name') }}. {{ __('common.rights') }}</p>
            <p>{{ __('common.built_note') }}</p>
        </div>
    </div>
</footer>

<x-layouts.app :meta="$meta">

    @php
        $email    = (string) setting('contact.email');
        $phone    = (string) setting('contact.phone');
        $whatsapp = (string) setting('contact.whatsapp');
    @endphp

    <x-page-header
        :eyebrow="setting_text('pages.contact_eyebrow')"
        :title="setting_text('pages.contact_title')"
        :lead="setting_text('pages.contact_lead')"
    />

    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-14 lg:grid-cols-[0.85fr_1.15fr] lg:gap-20">

            {{-- Direct channels --}}
            <div>
                @if (setting_text('contact.availability'))
                    <p class="reveal inline-flex items-center gap-2.5 rounded-full border border-primary/40 px-4 py-1.5 text-sm text-primary">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary" aria-hidden="true"></span>
                        {{ setting_text('contact.availability') }}
                    </p>
                @endif

                <ul class="mt-10 space-y-px">
                    @if ($email)
                        <li class="reveal border-t border-line py-5" data-reveal-index="1">
                            <p class="text-xs uppercase tracking-[0.18em] text-faint">{{ __('contact.email_label') }}</p>
                            <a href="mailto:{{ $email }}" class="link-underline mt-2 inline-block text-lg" dir="ltr">{{ $email }}</a>
                        </li>
                    @endif

                    @if ($phone)
                        <li class="reveal border-t border-line py-5" data-reveal-index="2">
                            <p class="text-xs uppercase tracking-[0.18em] text-faint">{{ __('contact.call') }}</p>
                            <a href="tel:{{ $phone }}" class="link-underline mt-2 inline-block text-lg" dir="ltr">{{ $phone }}</a>
                        </li>
                    @endif

                    @if ($whatsapp)
                        <li class="reveal border-t border-line py-5" data-reveal-index="3">
                            <p class="text-xs uppercase tracking-[0.18em] text-faint">{{ __('contact.whatsapp') }}</p>
                            <a
                                href="https://wa.me/{{ $whatsapp }}"
                                target="_blank" rel="noopener noreferrer"
                                class="link-underline mt-2 inline-block text-lg" dir="ltr"
                            >+{{ $whatsapp }}</a>
                        </li>
                    @endif

                    <li class="reveal border-y border-line py-5" data-reveal-index="4">
                        <p class="text-xs uppercase tracking-[0.18em] text-faint">{{ __('contact.location') }}</p>
                        <p class="mt-2 text-lg text-ink">{{ setting_text('contact.city') }}</p>
                    </li>
                </ul>
            </div>

            {{-- Form --}}
            <div class="reveal">
                <div class="panel relative overflow-hidden p-8 lg:p-12">
                    <x-plate-rings class="top-0 h-80 w-80 -translate-y-1/2" style="inset-inline-end: -5rem; inset-inline-start: auto;" opacity="0.18" />

                    <div class="relative">
                        <h2 class="font-display text-3xl text-ink">{{ setting_text('contact.form_title') }}</h2>
                        <p class="mt-2 text-sm text-muted">{{ setting_text('contact.form_note') }}</p>

                        @if (session('contact.success'))
                            <p
                                role="status"
                                class="mt-8 border-s-2 border-primary bg-surface-3 px-5 py-4 text-sm text-ink"
                            >
                                {{ session('contact.success') }}
                            </p>
                        @endif

                        @if ($errors->any())
                            <div role="alert" class="mt-8 border-s-2 border-primary bg-surface-3 px-5 py-4">
                                <p class="text-sm font-medium text-ink">{{ __('contact.error_title') }}</p>
                                <ul class="mt-2 space-y-1 text-sm text-muted">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}" class="mt-8 space-y-6">
                            @csrf

                            <div>
                                <label for="name" class="block text-xs uppercase tracking-[0.18em] text-faint">
                                    {{ __('contact.name') }}
                                </label>
                                <input
                                    type="text" id="name" name="name" required
                                    autocomplete="name" maxlength="120"
                                    value="{{ old('name') }}"
                                    @if ($errors->has('name')) aria-invalid="true" aria-describedby="name-error" @endif
                                    class="field mt-3"
                                >
                                @error('name')
                                    <p id="name-error" class="mt-2 text-xs text-primary">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-xs uppercase tracking-[0.18em] text-faint">
                                    {{ __('contact.email') }}
                                </label>
                                <input
                                    type="email" id="email" name="email" required
                                    autocomplete="email" maxlength="190" dir="ltr"
                                    value="{{ old('email') }}"
                                    @if ($errors->has('email')) aria-invalid="true" aria-describedby="email-error" @endif
                                    class="field mt-3"
                                >
                                @error('email')
                                    <p id="email-error" class="mt-2 text-xs text-primary">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-xs uppercase tracking-[0.18em] text-faint">
                                    {{ __('contact.message') }}
                                </label>
                                <textarea
                                    id="message" name="message" rows="5" required maxlength="4000"
                                    @if ($errors->has('message')) aria-invalid="true" aria-describedby="message-error" @endif
                                    class="field mt-3 resize-y"
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <p id="message-error" class="mt-2 text-xs text-primary">{{ $message }}</p>
                                @enderror
                            </div>

                            {{--
                            | Honeypot. Hidden from sighted users, taken out of the
                            | tab order, and hidden from assistive tech -- so only a
                            | bot filling every field will trip it.
                            --}}
                            <div class="absolute -left-[9999px]" aria-hidden="true">
                                <label for="company">{{ __('contact.company') }}</label>
                                <input type="text" id="company" name="company" tabindex="-1" autocomplete="off">
                            </div>

                            <button type="submit" class="btn btn-primary w-full sm:w-auto">
                                {{ __('contact.send') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>

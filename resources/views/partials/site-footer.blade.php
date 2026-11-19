{{--
    Shared site footer. Expects $categories and $siteName (from layouts.site).
--}}
<footer class="mt-8 border-t border-line bg-soft text-muted">
    <div class="mx-auto max-w-7xl px-4 pt-14 pb-10 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <a href="{{ route('home') }}" wire:navigate aria-label="{{ __(':site home', ['site' => $siteName]) }}">
                    @include('partials.logo')
                </a>
                <p class="mt-5 max-w-sm text-sm leading-relaxed">
                    {{ __('Clear, well-researched guides to wellness and beauty, fitness and food, travel and lifestyle, personal finance, and digital life.') }}
                </p>
            </div>

            <div class="grid gap-10 sm:grid-cols-3 lg:col-span-8">
                <div>
                    <p class="text-sm font-semibold text-ink">{{ __('Categories') }}</p>
                    <ul class="mt-4 space-y-2.5 text-sm">
                        @foreach ($categories as $category)
                            <li><a href="{{ route('section', $category['id']) }}" wire:navigate class="transition hover:text-ink">{{ $category['title'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-semibold text-ink">{{ $siteName }}</p>
                    <ul class="mt-4 space-y-2.5 text-sm">
                        <li><a href="{{ route('articles') }}" wire:navigate class="transition hover:text-ink">{{ __('All Articles') }}</a></li>
                        <li><a href="{{ route('team') }}" wire:navigate class="transition hover:text-ink">{{ __('Our Editorial Team') }}</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-semibold text-ink">{{ __('Legal') }}</p>
                    <ul class="mt-4 space-y-2.5 text-sm">
                        <li><a href="{{ route('privacy-policy') }}" wire:navigate class="transition hover:text-ink">{{ __('Privacy Policy') }}</a></li>
                        <li><a href="{{ route('terms-of-use') }}" wire:navigate class="transition hover:text-ink">{{ __('Terms of Use') }}</a></li>
                        <li><a href="{{ route('disclaimer') }}" wire:navigate class="transition hover:text-ink">{{ __('Disclaimer') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        @php($siteDomain = config('app.display_domain'))
        <div class="mt-12 space-y-3 border-t border-line pt-8 text-xs leading-relaxed">
            <p>
                <span class="font-semibold text-body">{{ __('Disclaimer:') }}</span>
                {{ __('The content on :domain is for general informational and educational purposes only and is not medical, financial, legal, or other professional advice. Always consult a qualified professional about your own situation before making health, financial, travel, or technology decisions.', ['domain' => $siteDomain]) }}
            </p>
            <p>{{ __(':domain makes no representations or warranties as to the accuracy, completeness, or suitability of the information contained herein, and assumes no liability for any losses or damages arising from the use of this content.', ['domain' => $siteDomain]) }}</p>
        </div>

        <div class="mt-8 flex flex-col items-center justify-between gap-3 text-xs sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ __('All rights reserved.') }}</p>
            <p>{{ \App\Support\SiteContent::domain() }}</p>
        </div>
    </div>
</footer>

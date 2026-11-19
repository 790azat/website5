{{--
    Shared site header: a single white bar with the logo, a Categories menu,
    article search and the Terms / Privacy policy links. Expects $categories
    (from layouts.site) and x-data="{ mobileOpen: false }" on <body>.
--}}
<header class="sticky top-0 z-40 border-b border-line bg-white/90 backdrop-blur-md">
    <div class="mx-auto flex h-16 max-w-7xl items-center gap-4 px-4 sm:px-6 lg:gap-6 lg:px-8">
        <a href="{{ route('home') }}" wire:navigate class="shrink-0" aria-label="{{ __(':site home', ['site' => config('app.name')]) }}">
            @include('partials.logo')
        </a>

        {{-- Categories menu --}}
        <div x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false" class="relative hidden lg:block">
            <button type="button" @click="open = ! open" :aria-expanded="open" class="inline-flex items-center gap-1.5 rounded-full bg-brand-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-700">
                {{ __('Categories') }}
                <flux:icon name="chevron-down" variant="micro" class="size-4 transition" ::class="open && 'rotate-180'" />
            </button>
            <div x-cloak x-show="open" x-transition.opacity.duration.150ms class="absolute top-full left-0 z-50 mt-3 w-80 rounded-2xl border border-line bg-white p-2 shadow-xl shadow-slate-900/10">
                @foreach ($categories as $category)
                    <a href="{{ route('section', $category['id']) }}" wire:navigate class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-soft">
                        <span class="flex size-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                            <flux:icon name="{{ $category['icon'] }}" variant="mini" class="size-4" />
                        </span>
                        <span class="min-w-0">
                            <span class="block text-sm font-medium text-ink">{{ $category['title'] }}</span>
                            <span class="block text-xs text-muted">{{ trans_choice(':count article|:count articles', $category['count']) }}</span>
                        </span>
                    </a>
                @endforeach
                <a href="{{ route('articles') }}" wire:navigate class="mt-1 flex items-center justify-between rounded-xl border-t border-line px-3 pt-3 pb-2 text-sm font-medium text-brand-600 hover:text-brand-700">
                    {{ __('All Articles') }}
                    <flux:icon name="arrow-right" variant="micro" class="size-4" />
                </a>
            </div>
        </div>

        <div class="hidden max-w-md flex-1 md:block">
            @include('partials.search-box', ['id' => 'header-search'])
        </div>

        <div class="ml-auto flex items-center gap-1 sm:gap-3">
            <nav class="hidden items-center gap-6 text-sm text-muted lg:flex">
                <a href="{{ route('terms-of-use') }}" wire:navigate class="transition hover:text-ink">{{ __('Terms') }}</a>
                <a href="{{ route('privacy-policy') }}" wire:navigate class="transition hover:text-ink">{{ __('Privacy policy') }}</a>
            </nav>

            <button
                type="button"
                @click="mobileOpen = true"
                class="flex size-10 items-center justify-center rounded-full text-ink transition hover:bg-soft lg:hidden"
                aria-label="{{ __('Open menu') }}"
            >
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round" />
                </svg>
            </button>
        </div>
    </div>
</header>

{{-- Mobile slide-over menu --}}
<div x-show="mobileOpen" x-cloak class="fixed inset-0 z-50 lg:hidden" @keydown.escape.window="mobileOpen = false">
    <div x-show="mobileOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm" @click="mobileOpen = false"></div>
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 flex w-full max-w-sm flex-col bg-white shadow-2xl"
    >
        <div class="flex items-center justify-between border-b border-line px-5 py-4">
            <a href="{{ route('home') }}" wire:navigate @click="mobileOpen = false">
                @include('partials.logo', ['size' => 'sm'])
            </a>
            <button type="button" @click="mobileOpen = false" class="flex size-10 items-center justify-center rounded-full text-ink hover:bg-soft" aria-label="{{ __('Close menu') }}">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <div class="px-5 pt-5 md:hidden">
            @include('partials.search-box', ['id' => 'mobile-search'])
        </div>

        <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto px-3 py-5">
            <a href="{{ route('home') }}" wire:navigate @click="mobileOpen = false" class="rounded-xl px-3 py-2.5 font-medium text-ink hover:bg-soft">{{ __('Home') }}</a>

            <p class="eyebrow mt-5 mb-1 px-3">{{ __('Categories') }}</p>
            @foreach ($categories as $category)
                <a href="{{ route('section', $category['id']) }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-body hover:bg-soft">
                    <span class="flex size-8 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                        <flux:icon name="{{ $category['icon'] }}" variant="mini" class="size-4" />
                    </span>
                    {{ $category['title'] }}
                </a>
            @endforeach

            <div class="mt-5 border-t border-line pt-4">
                <a href="{{ route('terms-of-use') }}" wire:navigate @click="mobileOpen = false" class="block rounded-xl px-3 py-2.5 text-body hover:bg-soft">{{ __('Terms') }}</a>
                <a href="{{ route('privacy-policy') }}" wire:navigate @click="mobileOpen = false" class="block rounded-xl px-3 py-2.5 text-body hover:bg-soft">{{ __('Privacy policy') }}</a>
            </div>
        </nav>
    </div>
</div>

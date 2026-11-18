{{--
    Header band for inner pages.
    Expects $heading; optional $eyebrow, $lead, $crumbs ([label => url|null]),
    $icon (Heroicon name) and $meta (small text line under the lead).
--}}
<section class="border-b border-line bg-gradient-to-b from-soft to-white">
    <div class="mx-auto max-w-7xl px-4 pt-8 pb-12 sm:px-6 lg:px-8 lg:pb-16">
        @if (! empty($crumbs))
            <nav class="flex flex-wrap items-center gap-1.5 text-sm text-muted" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-ink">{{ __('Home') }}</a>
                @foreach ($crumbs as $label => $url)
                    <flux:icon name="chevron-right" variant="micro" class="size-3.5 text-zinc-300" />
                    @if ($url)
                        <a href="{{ $url }}" wire:navigate class="hover:text-ink">{{ $label }}</a>
                    @else
                        <span class="min-w-0 truncate text-body">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        @endif

        <div class="mt-10 flex flex-col gap-8 md:flex-row md:items-end md:justify-between">
            <div class="max-w-3xl">
                @if (! empty($eyebrow))
                    <span class="eyebrow">{{ $eyebrow }}</span>
                @endif
                <h1 class="mt-3 text-4xl leading-[1.1] font-semibold tracking-tight text-balance text-ink sm:text-5xl">
                    {{ $heading }}
                </h1>
                @if (! empty($lead))
                    <p class="mt-5 text-lg leading-relaxed text-pretty text-muted">{{ $lead }}</p>
                @endif
                @if (! empty($meta))
                    <p class="mt-5 inline-flex rounded-full border border-line bg-white px-3 py-1 text-xs font-medium text-body">{{ $meta }}</p>
                @endif
            </div>

            @if (! empty($icon))
                <span class="hidden size-20 shrink-0 items-center justify-center rounded-3xl bg-brand-50 text-brand-600 md:flex">
                    <flux:icon name="{{ $icon }}" class="size-9" />
                </span>
            @endif
        </div>
    </div>
</section>

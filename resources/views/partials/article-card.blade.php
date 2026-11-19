{{--
    Article card. Expects $article (from SiteContent) and optional
    $variant: 'grid' (default), 'featured' (image beside the text), or
    'compact' (small row for sidebars / related lists).
--}}
@php $variant = $variant ?? 'grid'; @endphp

@if ($variant === 'featured')
    <a href="{{ route('article', $article['slug']) }}" wire:navigate class="group grid overflow-hidden rounded-3xl border border-line bg-white shadow-sm transition hover:shadow-xl hover:shadow-slate-900/5 md:grid-cols-2">
        <div class="relative flex aspect-[4/3] items-center justify-center overflow-hidden md:aspect-auto md:min-h-[22rem]">
            @include('partials.article-art', ['iconClass' => 'size-16'])
        </div>
        <div class="flex flex-col justify-center p-7 sm:p-10">
            <span class="tag">{{ $article['section_title'] }}</span>
            <h3 class="mt-4 text-2xl leading-snug font-semibold tracking-tight text-balance text-ink sm:text-3xl">{{ $article['title'] }}</h3>
            <p class="mt-4 line-clamp-3 leading-relaxed text-muted">{{ $article['excerpt'] }}</p>
            <p class="mt-6 text-sm text-muted">
                {{ $article['author_info']['name'] }} &middot; {{ __(':minutes min read', ['minutes' => $article['reading_minutes']]) }}
            </p>
            <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-medium text-brand-600">
                {{ __('Read more') }}
                <flux:icon name="arrow-right" variant="micro" class="size-4 transition group-hover:translate-x-1" />
            </span>
        </div>
    </a>
@elseif ($variant === 'compact')
    <a href="{{ route('article', $article['slug']) }}" wire:navigate class="group flex min-w-0 items-center gap-4">
        <div class="relative flex size-20 shrink-0 items-center justify-center overflow-hidden rounded-xl">
            @include('partials.article-art', ['iconClass' => 'size-7'])
        </div>
        <div class="min-w-0">
            <p class="text-[11px] font-medium text-brand-600">{{ $article['section_title'] }}</p>
            <p class="mt-1 line-clamp-2 font-medium leading-snug text-ink group-hover:text-brand-700">{{ $article['title'] }}</p>
            <p class="mt-1 text-xs text-muted">{{ __(':minutes min read', ['minutes' => $article['reading_minutes']]) }}</p>
        </div>
    </a>
@else
    <a href="{{ route('article', $article['slug']) }}" wire:navigate class="group flex flex-col">
        <div class="relative flex aspect-[4/3] items-center justify-center overflow-hidden rounded-2xl bg-soft">
            @include('partials.article-art')
            <span class="chip absolute top-3 left-3">{{ $article['section_title'] }}</span>
        </div>
        <div class="flex flex-1 flex-col px-1 pt-4">
            <h3 class="line-clamp-2 text-[1.0625rem] leading-snug font-medium text-ink transition group-hover:text-brand-700">
                {{ $article['title'] }}
            </h3>
            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-muted">{{ $article['excerpt'] }}</p>
            <p class="mt-auto flex items-center gap-2 pt-4 text-xs text-muted">
                <time datetime="{{ $article['date'] }}">{{ \Carbon\Carbon::parse($article['date'])->translatedFormat(__('M j, Y')) }}</time>
                <span class="size-0.5 rounded-full bg-muted"></span>
                {{ __(':minutes min read', ['minutes' => $article['reading_minutes']]) }}
            </p>
        </div>
    </a>
@endif

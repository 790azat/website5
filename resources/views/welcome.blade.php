@extends('layouts.site')
@use('App\Support\SiteContent')

@php
    $siteName = config('app.name', 'Laravel');
    $title = null;
    $description = __(':site publishes clear, research-driven guides to wellness and beauty, fitness and food, travel and lifestyle, personal finance, and digital life.', ['site' => $siteName]);

    $categories = SiteContent::categories();
    $allArticles = SiteContent::articles();
    $heroArticle = $allArticles->first();

    // Popular: the newest two from each topic, interleaved so every topic shows up.
    $perTopic = $categories->map(fn ($category) => SiteContent::articles($category['id'])->where('slug', '!=', $heroArticle['slug'] ?? null)->values());
    $popular = collect();
    foreach ([0, 1] as $n) {
        foreach ($perTopic as $list) {
            if ($list->has($n)) {
                $popular->push($list->get($n));
            }
        }
    }
    $popular = $popular->take(8);
    $popularSlugs = $popular->pluck('slug')->push($heroArticle['slug'] ?? null);

    $remaining = $allArticles->whereNotIn('slug', $popularSlugs)->values();
    $featuredArticle = $remaining->first();
    $latestArticles = $remaining->slice(1, 8)->values();

    $topicBlocks = $categories->map(fn ($category) => $category + ['articles' => SiteContent::articles($category['id'])->take(3)]);
@endphp

@section('content')
    {{-- Hero: the newest article, text beside a large image --}}
    @if ($heroArticle)
        <section class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8 lg:pt-10">
            <a href="{{ route('article', $heroArticle['slug']) }}" wire:navigate class="group grid overflow-hidden rounded-3xl bg-soft lg:grid-cols-2">
                <div class="order-2 flex flex-col justify-center p-7 sm:p-10 lg:order-1 lg:p-14">
                    <span class="tag w-fit bg-white">{{ $heroArticle['section_title'] }}</span>
                    <h1 class="mt-5 text-3xl leading-[1.12] font-semibold tracking-tight text-balance text-ink sm:text-4xl lg:text-5xl">
                        {{ $heroArticle['title'] }}
                    </h1>
                    <p class="mt-5 line-clamp-3 max-w-xl text-base leading-relaxed text-muted sm:text-lg">{{ $heroArticle['excerpt'] }}</p>
                    <div class="mt-8 flex flex-wrap items-center gap-5">
                        <span class="btn-primary">
                            {{ __('Read more') }}
                            <flux:icon name="arrow-right" variant="mini" class="size-4 transition group-hover:translate-x-0.5" />
                        </span>
                        <span class="text-sm text-muted">{{ __(':minutes min read', ['minutes' => $heroArticle['reading_minutes']]) }}</span>
                    </div>
                </div>
                <div class="relative order-1 flex aspect-[16/10] items-center justify-center overflow-hidden lg:order-2 lg:aspect-auto lg:min-h-[30rem]">
                    @include('partials.article-art', ['article' => $heroArticle, 'iconClass' => 'size-20'])
                </div>
            </a>
        </section>
    @endif

    {{-- Category chips --}}
    <section class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
        <div class="flex gap-2.5 overflow-x-auto pb-1 [scrollbar-width:none]">
            @foreach ($categories as $category)
                <a href="{{ route('section', $category['id']) }}" wire:navigate class="inline-flex shrink-0 items-center gap-2 rounded-full border border-line bg-white px-4 py-2 text-sm text-body transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-700">
                    <flux:icon name="{{ $category['icon'] }}" variant="mini" class="size-4 text-brand-500" />
                    {{ $category['title'] }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- Popular articles --}}
    @if ($popular->isNotEmpty())
        <section id="popular" class="mx-auto max-w-7xl scroll-mt-24 px-4 pt-16 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-6">
                <h2 class="text-3xl font-semibold tracking-tight text-ink">{{ __('Popular Articles') }}</h2>
                <a href="{{ route('articles') }}" wire:navigate class="hidden text-sm font-medium text-brand-600 hover:text-brand-700 sm:inline-flex sm:items-center sm:gap-1">
                    {{ __('Show more') }}
                    <flux:icon name="arrow-right" variant="micro" class="size-4" />
                </a>
            </div>
            <div class="mt-8 grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($popular as $article)
                    @include('partials.article-card', ['article' => $article])
                @endforeach
            </div>
        </section>
    @else
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @include('partials.empty-state')
        </section>
    @endif

    {{-- Categories --}}
    <section class="mx-auto max-w-7xl px-4 pt-20 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <h2 class="text-3xl font-semibold tracking-tight text-ink">{{ __('Categories') }}</h2>
            <p class="mt-3 leading-relaxed text-muted">{{ __('Five areas of everyday life, explained clearly and in depth.') }}</p>
        </div>
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($topicBlocks as $block)
                <div class="flex flex-col rounded-3xl border border-line bg-white p-7 transition hover:shadow-lg hover:shadow-slate-900/5">
                    <div class="flex items-center gap-3">
                        <span class="flex size-11 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                            <flux:icon name="{{ $block['icon'] }}" class="size-5" />
                        </span>
                        <div>
                            <h3 class="font-semibold text-ink">{{ $block['title'] }}</h3>
                            <p class="text-xs text-muted">{{ trans_choice(':count article|:count articles', $block['count']) }}</p>
                        </div>
                    </div>
                    @if ($block['description'])
                        <p class="mt-4 text-sm leading-relaxed text-muted">{{ $block['description'] }}</p>
                    @endif
                    <ul class="mt-5 space-y-3 border-t border-line pt-5">
                        @foreach ($block['articles'] as $article)
                            <li>
                                <a href="{{ route('article', $article['slug']) }}" wire:navigate class="line-clamp-2 text-sm leading-snug text-body transition hover:text-brand-700">{{ $article['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('section', $block['id']) }}" wire:navigate class="mt-auto inline-flex items-center gap-1 pt-6 text-sm font-medium text-brand-600 hover:text-brand-700">
                        {{ __('Show more') }}
                        <flux:icon name="arrow-right" variant="micro" class="size-4" />
                    </a>
                </div>
            @endforeach

            {{-- Library teaser fills the last cell of the grid --}}
            <a href="{{ route('articles') }}" wire:navigate class="group flex flex-col justify-between rounded-3xl bg-brand-600 p-7 text-white">
                <div>
                    <p class="text-sm text-brand-100">{{ __('The full library') }}</p>
                    <p class="mt-2 text-xl leading-snug font-semibold text-balance">{{ __('Browse every guide in one place, newest first') }}</p>
                </div>
                <div class="mt-8 flex items-center justify-between">
                    <span class="text-sm text-brand-100">{{ trans_choice(':count article|:count articles', $allArticles->count()) }}</span>
                    <flux:icon name="arrow-right" variant="mini" class="size-5 transition group-hover:translate-x-1" />
                </div>
            </a>
        </div>
    </section>

    {{-- Featured pick --}}
    @if ($featuredArticle)
        <section class="mx-auto max-w-7xl px-4 pt-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold tracking-tight text-ink">{{ __('Editor’s Pick') }}</h2>
            <div class="mt-8">
                @include('partials.article-card', ['article' => $featuredArticle, 'variant' => 'featured'])
            </div>
        </section>
    @endif

    {{-- Latest articles --}}
    @if ($latestArticles->isNotEmpty())
        <section id="latest" class="mx-auto max-w-7xl scroll-mt-24 px-4 pt-20 pb-16 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold tracking-tight text-ink">{{ __('Latest Articles') }}</h2>
            <div class="mt-8 grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($latestArticles as $article)
                    @include('partials.article-card', ['article' => $article])
                @endforeach
            </div>
            <div class="mt-12 flex justify-center">
                <a href="{{ route('articles') }}" wire:navigate class="btn-ghost">
                    {{ __('Show more') }}
                    <flux:icon name="arrow-right" variant="mini" class="size-4" />
                </a>
            </div>
        </section>
    @endif
@endsection

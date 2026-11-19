@extends('layouts.site')
@use('App\Support\SiteContent')

@php
    $article = SiteContent::article($slug);

    if (! $article) {
        abort(404);
    }

    $siteName = config('app.name', 'Laravel');
    $rendered = \App\Support\ArticleMarkdown::render($article['body']);
    $publishedAt = \Carbon\Carbon::parse($article['date']);

    $relatedArticles = SiteContent::articles($article['section'])
        ->where('slug', '!=', $article['slug'])
        ->take(3)
        ->values();

    $title = $article['title'];
    $description = Str::limit($article['excerpt'], 155);
    $shareArticle = $article;
@endphp

@section('content')
    <article>
        {{-- Article header --}}
        <header class="mx-auto max-w-4xl px-4 pt-8 sm:px-6 lg:px-8">
            <nav class="flex flex-wrap items-center gap-1.5 text-sm text-muted" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-ink">{{ __('Home') }}</a>
                <flux:icon name="chevron-right" variant="micro" class="size-3.5 text-zinc-300" />
                <a href="{{ route('section', $article['section']) }}" wire:navigate class="hover:text-ink">{{ $article['section_title'] }}</a>
            </nav>

            <a href="{{ route('section', $article['section']) }}" wire:navigate class="tag mt-10">
                <flux:icon name="{{ $article['section_icon'] }}" variant="micro" class="size-3.5" />
                {{ $article['section_title'] }}
            </a>

            <h1 class="mt-5 text-4xl leading-[1.1] font-semibold tracking-tight text-balance text-ink sm:text-5xl">
                {{ $article['title'] }}
            </h1>

            <div class="mt-8 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-muted">
                <time datetime="{{ $article['date'] }}">{{ $publishedAt->translatedFormat(__('F j, Y')) }}</time>
                <span class="size-1 rounded-full bg-zinc-300"></span>
                <span>{{ __(':minutes min read', ['minutes' => $article['reading_minutes']]) }}</span>
            </div>
        </header>

        @if ($article['image'])
            <div class="mx-auto mt-10 max-w-6xl px-4 sm:px-6 lg:px-8">
                <img src="{{ asset('images/'.$article['image']) }}" alt="{{ $article['title'] }}" class="aspect-[16/9] w-full rounded-3xl object-cover sm:aspect-[21/9]" />
            </div>
        @endif

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if ($article['locale'] !== app()->getLocale())
                <p class="mx-auto mt-10 flex max-w-3xl items-start gap-3 rounded-2xl bg-brand-50 p-5 text-sm leading-relaxed text-body">
                    <flux:icon name="language" variant="mini" class="mt-0.5 size-5 shrink-0 text-brand-600" />
                    {{ __('This article is currently available in English only.') }}
                </p>
            @endif

            <div class="grid gap-12 pt-12 pb-16 lg:grid-cols-12">
                {{-- Table of contents --}}
                @if (count($rendered['toc']) > 1)
                    <aside class="lg:col-span-4 lg:order-2">
                        <nav class="rounded-2xl border border-line bg-white p-5 lg:sticky lg:top-24" aria-label="{{ __('In this article') }}" x-data="{ open: false }">
                            <button type="button" class="flex w-full items-center justify-between text-left lg:pointer-events-none" @click="open = ! open">
                                <span class="text-sm font-semibold text-ink">{{ __('In this article') }}</span>
                                <flux:icon name="chevron-down" variant="mini" class="size-4 text-muted transition lg:hidden" ::class="open && 'rotate-180'" />
                            </button>
                            <ol class="mt-3 hidden max-h-[60vh] space-y-0.5 overflow-y-auto text-sm lg:block" :class="open && '!block'">
                                @foreach ($rendered['toc'] as $item)
                                    <li>
                                        <a href="#{{ $item['id'] }}" @click="open = false" class="block rounded-lg px-3 py-1.5 leading-snug text-muted transition hover:bg-soft hover:text-ink">{{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    </aside>
                @endif

                <div class="min-w-0 lg:col-span-8 lg:order-1">
                    @include('partials.article-body', ['html' => $rendered['html']])

                    <p class="mt-14 flex gap-3 rounded-2xl border border-line p-5 text-sm leading-relaxed text-muted">
                        <flux:icon name="information-circle" variant="mini" class="size-5 shrink-0 text-brand-500" />
                        <span>
                            <span class="font-medium text-body">{{ __('Educational content only.') }}</span>
                            {{ __('This article is for general information and is not personalized medical, financial, or professional advice.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </article>

    {{-- Related articles --}}
    @if ($relatedArticles->isNotEmpty())
        <section class="border-t border-line">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <h2 class="text-2xl font-semibold tracking-tight text-ink">{{ __('More in :section', ['section' => $article['section_title']]) }}</h2>
                    <a href="{{ route('section', $article['section']) }}" wire:navigate class="inline-flex items-center gap-1 text-sm font-medium text-brand-600 hover:text-brand-700">
                        {{ __('Show more') }}
                        <flux:icon name="arrow-right" variant="micro" class="size-4" />
                    </a>
                </div>
                <div class="mt-8 grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedArticles as $related)
                        @include('partials.article-card', ['article' => $related])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

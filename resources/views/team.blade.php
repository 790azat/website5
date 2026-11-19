@extends('layouts.site')
@use('App\Support\SiteContent')

@php
    $siteName = config('app.name', 'Laravel');
    $siteDomain = config('app.display_domain');
    $title = __('Our Editorial Team');
    $description = __('Meet the :site team: editors and writers covering wellness and beauty, fitness and food, travel and lifestyle, personal finance, and digital life.', ['site' => $siteName]);

    $team = SiteContent::authors();
    $categories = SiteContent::categories();

    $principles = [
        ['icon' => 'magnifying-glass', 'title' => __('Researched'), 'text' => __('Every guide draws on established research, professional guidance, and publicly available sources.')],
        ['icon' => 'light-bulb', 'title' => __('Clear'), 'text' => __('We explain complex subjects in plain language, without unnecessary jargon or exaggerated claims.')],
        ['icon' => 'scale', 'title' => __('Balanced'), 'text' => __('We lay out benefits, costs, and trade-offs so you can weigh your options yourself.')],
    ];
@endphp

@section('content')
    @include('partials.page-hero', [
        'crumbs' => [__('Our Team') => null],
        'eyebrow' => $siteDomain,
        'heading' => __('Our Editorial Team'),
        'lead' => __('At :site, our editors make everyday topics easier to understand. Our writers cover skincare and wellness, nutrition and training, travel planning, money management, and the technology we use every day, with a focus on clear, practical, and well-researched information.', ['site' => $siteDomain]),
        'icon' => 'user-group',
    ])

    {{-- Team grid --}}
    <section id="team" class="mx-auto max-w-7xl scroll-mt-24 px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($team as $member)
                <a href="{{ route('author', $member['key']) }}" wire:navigate class="group flex flex-col rounded-3xl border border-line bg-white p-7 transition hover:shadow-lg hover:shadow-slate-900/5">
                    @include('partials.avatar', ['author' => $member, 'class' => 'size-16 text-lg'])
                    <h2 class="mt-5 text-lg font-semibold text-ink group-hover:text-brand-700">{{ $member['name'] }}</h2>
                    <p class="mt-0.5 text-sm text-brand-600">{{ $member['role'] }}</p>
                    @if (! empty($member['bio']))
                        <p class="mt-4 text-sm leading-relaxed text-muted">{{ $member['bio'] }}</p>
                    @endif
                    <p class="mt-auto flex items-center justify-between gap-3 pt-6 text-sm">
                        <span class="inline-flex items-center gap-1 font-medium text-brand-600">{{ __('Read full bio') }} <flux:icon name="arrow-right" variant="micro" class="size-4" /></span>
                        @if ($member['count'])
                            <span class="text-muted">{{ trans_choice(':count article|:count articles', $member['count']) }}</span>
                        @endif
                    </p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Mission --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-soft px-6 py-16 text-center sm:px-14">
            <span class="eyebrow">{{ __('Our mission') }}</span>
            <p class="mx-auto mt-5 max-w-3xl text-2xl leading-snug font-medium text-balance text-ink sm:text-3xl">
                &ldquo;{{ __('To give people clear, practical information about the everyday choices that shape their health, money, travels, and digital lives.') }}&rdquo;
            </p>
        </div>
    </section>

    {{-- What we cover --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-semibold tracking-tight text-ink">{{ __('What we cover') }}</h2>
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($categories as $category)
                <a href="{{ route('section', $category['id']) }}" wire:navigate class="group rounded-3xl border border-line bg-white p-6 transition hover:border-brand-200 hover:bg-brand-50/40">
                    <span class="flex size-11 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                        <flux:icon name="{{ $category['icon'] }}" class="size-5" />
                    </span>
                    <h3 class="mt-5 font-semibold text-ink">{{ $category['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">{{ $category['description'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Approach --}}
    <section class="mx-auto grid max-w-7xl gap-12 px-4 pb-20 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div>
            <h2 class="text-3xl font-semibold tracking-tight text-balance text-ink">{{ __('Information should be easy to evaluate') }}</h2>
            <p class="mt-5 leading-relaxed text-body">
                {{ __('We present information in context: a treatment, a training plan, a travel policy, or a loan is examined alongside its costs, risks, and long-term trade-offs.') }}
            </p>
            <p class="mt-4 leading-relaxed text-body">
                {{ __('Our articles explain concepts, highlight important considerations, and help you understand how different choices can affect your outcomes.') }}
            </p>
            <div id="disclaimer" class="mt-8 rounded-2xl border border-line p-6 text-sm leading-relaxed text-muted">
                <h3 class="font-semibold text-ink">{{ __('Disclaimer') }}</h3>
                <p class="mt-2">{{ __('The information published on :site is provided for general informational and educational purposes only. Our articles are not medical, financial, legal, or other professional advice. Always consult a qualified professional about your specific circumstances.', ['site' => $siteDomain]) }}</p>
            </div>
        </div>

        <div class="space-y-4">
            @foreach ($principles as $principle)
                <div class="flex gap-5 rounded-3xl border border-line bg-white p-6">
                    <span class="flex size-11 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                        <flux:icon name="{{ $principle['icon'] }}" class="size-5" />
                    </span>
                    <div>
                        <h3 class="font-semibold text-ink">{{ $principle['title'] }}</h3>
                        <p class="mt-1 text-sm leading-relaxed text-muted">{{ $principle['text'] }}</p>
                    </div>
                </div>
            @endforeach
            <a href="{{ route('articles') }}" wire:navigate class="btn-primary mt-2">
                {{ __('Explore our articles') }}
                <flux:icon name="arrow-right" variant="mini" class="size-4" />
            </a>
        </div>
    </section>
@endsection

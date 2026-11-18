@extends('layouts.site')
@use('App\Support\SiteContent')

@php
    $siteName = config('app.name', 'Laravel');
    $domainName = SiteContent::domain();
    $title = __('Contact');
    $description = __('Get in touch with the :site team.', ['site' => $siteName]);

    $channels = [
        ['icon' => 'envelope', 'title' => __('General inquiries'), 'text' => __('Questions about our content, partnerships, or anything else.'), 'email' => 'hello@'.$domainName],
        ['icon' => 'pencil-square', 'title' => __('Editorial & corrections'), 'text' => __('Spotted something that needs a closer look? Let our editors know.'), 'email' => 'editorial@'.$domainName],
    ];
@endphp

@section('content')
    @include('partials.page-hero', [
        'crumbs' => [__('Contact') => null],
        'eyebrow' => __('Contact'),
        'heading' => __('Let’s talk'),
        'lead' => __('Have a question about an article, a correction to suggest, or feedback on :site? We would like to hear from you.', ['site' => $siteName]),
        'icon' => 'chat-bubble-left-right',
    ])

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-5 lg:grid-cols-3">
            @foreach ($channels as $channel)
                <a href="mailto:{{ $channel['email'] }}" class="group flex flex-col rounded-3xl border border-line bg-white p-8 transition hover:shadow-lg hover:shadow-slate-900/5">
                    <span class="flex size-12 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                        <flux:icon name="{{ $channel['icon'] }}" class="size-6" />
                    </span>
                    <h2 class="mt-6 text-xl font-semibold text-ink">{{ $channel['title'] }}</h2>
                    <p class="mt-2 leading-relaxed text-muted">{{ $channel['text'] }}</p>
                    <span class="mt-8 inline-flex items-center gap-2 font-medium break-all text-brand-600">
                        {{ $channel['email'] }}
                        <flux:icon name="arrow-up-right" variant="mini" class="size-4 shrink-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                    </span>
                </a>
            @endforeach

            <div class="flex flex-col rounded-3xl bg-brand-600 p-8 text-white">
                <span class="flex size-12 items-center justify-center rounded-full bg-white/15">
                    <flux:icon name="clock" class="size-6" />
                </span>
                <h2 class="mt-6 text-xl font-semibold">{{ __('Response time') }}</h2>
                <p class="mt-2 leading-relaxed text-brand-100">
                    {{ __('We aim to respond to every message within a few business days.') }}
                </p>
            </div>
        </div>

        <div class="mt-8 flex gap-4 rounded-2xl bg-soft p-6 text-sm leading-relaxed text-muted">
            <flux:icon name="information-circle" class="size-6 shrink-0 text-brand-500" />
            <p>
                {{ __(':site publishes educational and informational content only; we are not able to provide personalized medical, financial, or professional advice through this contact channel.', ['site' => $siteName]) }}
            </p>
        </div>
    </section>
@endsection

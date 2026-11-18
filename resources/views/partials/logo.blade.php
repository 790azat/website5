{{--
    Brand logo: the sun mark plus the site name (config app.name).
    Options: $invert (bool) for dark backgrounds, $size ('sm' | 'md').
--}}
@php
    $invert = $invert ?? false;
    $small = ($size ?? 'md') === 'sm';
@endphp
<span class="inline-flex shrink-0 items-center gap-2">
    @include('partials.logo-mark', ['class' => $small ? 'size-7' : 'size-8'])
    <span @class([
        'leading-none font-semibold tracking-tight',
        'text-lg' => $small,
        'text-xl' => ! $small,
        'text-white' => $invert,
        'text-ink' => ! $invert,
    ])>{{ config('app.name') }}</span>
</span>

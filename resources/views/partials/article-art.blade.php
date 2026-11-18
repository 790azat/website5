{{--
    Cover area for an article card: the article image when it exists,
    otherwise a soft gradient with the section icon. Expects $article; optional $iconClass.
--}}
@if ($article['image'])
    <img
        src="{{ asset('images/'.$article['image']) }}"
        alt="{{ $article['title'] }}"
        loading="lazy"
        decoding="async"
        class="absolute inset-0 size-full object-cover transition duration-500 group-hover:scale-[1.03]"
    />
@else
    <div class="absolute inset-0 bg-gradient-to-br from-brand-50 via-white to-sky-100"></div>
    <flux:icon name="{{ $article['section_icon'] }}" class="relative {{ $iconClass ?? 'size-12' }} text-brand-400" />
@endif

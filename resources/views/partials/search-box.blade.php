{{--
    Article search: filters an inline index of this locale's articles as you type.
    Results are real links rendered here (not built in JS) so the static export
    rewrites them to the right path and language like every other link.
    Options: $id (input id, required to be unique per page), $size ('sm' | 'lg').
--}}
@php
    $searchArticles = \App\Support\SiteContent::articles();
    $searchIndex = $searchArticles->map(fn ($article) => mb_strtolower($article['title'].' '.$article['section_title'].' '.$article['excerpt']))->values();
    $large = ($size ?? 'sm') === 'lg';
@endphp
<div
    x-data="{
        query: '',
        open: false,
        texts: @js($searchIndex),
        get results() {
            const words = this.query.toLowerCase().split(/\s+/).filter(Boolean);
            if (! words.length) return [];
            const found = [];
            for (let i = 0; i < this.texts.length && found.length < 6; i++) {
                if (words.every(word => this.texts[i].includes(word))) found.push(i);
            }
            return found;
        },
    }"
    @click.outside="open = false"
    @keydown.escape="open = false"
    class="relative w-full"
>
    <form role="search" @submit.prevent="if (results.length) $refs['result' + results[0]].click()">
        <label for="{{ $id }}" class="sr-only">{{ __('Search articles') }}</label>
        <div class="relative">
            <flux:icon name="magnifying-glass" variant="mini" @class(['pointer-events-none absolute top-1/2 -translate-y-1/2 text-muted', 'left-3.5 size-4' => ! $large, 'left-5 size-5' => $large]) />
            <input
                id="{{ $id }}"
                type="search"
                autocomplete="off"
                x-model="query"
                @focus="open = true"
                @input="open = true"
                placeholder="{{ __('Search articles...') }}"
                @class([
                    'w-full rounded-full border border-transparent bg-soft text-ink placeholder:text-muted transition focus:border-brand-300 focus:bg-white focus:ring-4 focus:ring-brand-100 focus:outline-none',
                    'py-2 pr-4 pl-10 text-sm' => ! $large,
                    'py-4 pr-5 pl-13 text-base shadow-sm ring-1 ring-line' => $large,
                ])
            />
        </div>
    </form>

    <div
        x-cloak
        x-show="open && query.trim() !== ''"
        x-transition.opacity
        class="absolute inset-x-0 top-full z-50 mt-2 flex max-h-[70vh] flex-col overflow-y-auto rounded-2xl border border-line bg-white shadow-xl shadow-slate-900/10"
    >
        @foreach ($searchArticles as $i => $article)
            <a
                href="{{ route('article', $article['slug']) }}"
                x-ref="result{{ $i }}"
                :style="{ order: results.indexOf({{ $i }}) }"
                class="hidden border-b border-line px-5 py-3 last:border-0 hover:bg-soft focus:bg-soft focus:outline-none"
                :class="{ 'hidden': ! results.includes({{ $i }}), 'block': results.includes({{ $i }}) }"
            >
                <span class="block text-[11px] font-medium text-brand-600">{{ $article['section_title'] }}</span>
                <span class="mt-0.5 block text-sm font-medium text-ink">{{ $article['title'] }}</span>
            </a>
        @endforeach
        <p x-show="results.length === 0" class="px-5 py-4 text-sm text-muted">{{ __('No articles found.') }}</p>
    </div>
</div>

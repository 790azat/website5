{{--
    Brand mark: a white sun on a rounded blue tile.
    Optional $class for size (default size-8).
--}}
<svg class="{{ $class ?? 'size-8' }} shrink-0" viewBox="0 0 32 32" aria-hidden="true">
    <rect width="32" height="32" rx="8" fill="#2563eb" />
    <circle cx="16" cy="16" r="5.2" fill="#fff" />
    <g stroke="#fff" stroke-width="1.8" stroke-linecap="round">
        <path d="M16 5.5v2.6M16 23.9v2.6M5.5 16h2.6M23.9 16h2.6M8.6 8.6l1.8 1.8M21.6 21.6l1.8 1.8M8.6 23.4l1.8-1.8M21.6 10.4l1.8-1.8" />
    </g>
</svg>

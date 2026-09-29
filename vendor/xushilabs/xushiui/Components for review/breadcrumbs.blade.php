@props([
    'separator' => '/',
    'size' => 'sm',
    'margin' => null,
])

@php
    $style = collect([
        'display' => 'flex',
        'align-items' => 'center',
        'flex-wrap' => 'wrap',
        'gap' => '0.25rem',
        'margin' => $margin,
        'font-size' => $size === 'md' ? '0.9375rem' : '0.8125rem',
        'list-style' => 'none',
        'padding' => '0',
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    view()->share('xushi_breadcrumb_separator', $separator);
@endphp

<nav aria-label="Breadcrumb" {{ $attributes->except('class') }}>
    <ol
        class="xushi-breadcrumbs"
        style="{{ $style }}"
    >
        {{ $slot }}
    </ol>
</nav>

@php
    // Clean up — unshare so it doesn't leak to other views
    view()->share('xushi_breadcrumb_separator', null);
@endphp

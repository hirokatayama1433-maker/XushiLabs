@props([
    'variant' => 'soft',
    'color' => 'base',
    'size' => 'md',
    'src' => null,
    'alt' => 'Avatar',
    'radius' => '999px',
    'shadow' => null,
    'margin' => null,
    'border' => '0px',
    'bordercolor' => null,
])

@php
    $variantStyles = [
        'solid' => [
            'primary' => ['background' => 'var(--xushi-color-primary)', 'color' => 'var(--xushi-color-primary-content)'],
            'secondary' => ['background' => 'var(--xushi-color-secondary)', 'color' => 'var(--xushi-color-secondary-content)'],
            'base' => ['background' => 'var(--xushi-color-base-300)', 'color' => 'var(--xushi-color-base-content)'],
        ],
        'soft' => [
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 18%, transparent)', 'color' => 'var(--xushi-color-primary)'],
            'secondary' => ['background' => 'color-mix(in oklch, var(--xushi-color-secondary) 18%, transparent)', 'color' => 'var(--xushi-color-secondary)'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['soft']['base'];

    $style = collect(array_merge([
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $initials = collect(explode(' ', trim($alt ?: $name)))
        ->filter()
        ->map(fn($w) => strtoupper($w[0] ?? ''))
        ->take(2)
        ->join('');
    if ($initials === '') $initials = '?';
@endphp

@once
 <style>
        /* ── Avatar ── */
    .xushi-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border-style: solid;
        box-sizing: border-box;
    }

    .xushi-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .xushi-avatar--sm { width: 2rem;   height: 2rem;   font-size: 0.75rem; }
    .xushi-avatar--md { width: 2.5rem; height: 2.5rem; font-size: 0.875rem; }
    .xushi-avatar--lg { width: 3rem;   height: 3rem;   font-size: 1rem; }
    .xushi-avatar--xl { width: 4rem;   height: 4rem;   font-size: 1.25rem; } </style>    
@endonce

<div class="xushi-avatar xushi-avatar--{{ $size }}" style="{{ $style }}" {{ $attributes }}>
    @if($src !== null)
        <img src="{{ $src }}" alt="{{ $alt ?: $name }}">
    @else
        <span>{{ $initials }}</span>
    @endif
</div>

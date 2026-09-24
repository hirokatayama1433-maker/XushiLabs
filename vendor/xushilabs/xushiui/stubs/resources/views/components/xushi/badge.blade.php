@props([
    'variant'    => 'soft',
    'color'      => 'base',
    'size'       => 'md',
    'padding'    => null,
    'radius'     => 'var(--xushi-radius-selector)',
    'shadow'     => null,
    'gap'        => '0.25rem',
    'margin'     => null,
    'border'     => null,
    'bordercolor' => null,
])

@php
    $variantStyles = [
        'solid' => [
            'primary' => ['background' => 'var(--xushi-color-primary)', 'color' => 'var(--xushi-color-primary-content)'],
            'secondary' => ['background' => 'var(--xushi-color-secondary)', 'color' => 'var(--xushi-color-secondary-content)'],
            'danger' => ['background' => 'var(--xushi-color-danger)', 'color' => 'var(--xushi-color-danger-content)'],
            'success' => ['background' => 'var(--xushi-color-success)', 'color' => 'var(--xushi-color-success-content)'],
            'warning' => ['background' => 'var(--xushi-color-warning)', 'color' => 'var(--xushi-color-warning-content)'],
            'info' => ['background' => 'var(--xushi-color-info)', 'color' => 'var(--xushi-color-info-content)'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
        ],
        'soft' => [
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 18%, transparent)', 'color' => 'var(--xushi-color-primary)'],
            'secondary' => ['background' => 'color-mix(in oklch, var(--xushi-color-secondary) 18%, transparent)', 'color' => 'var(--xushi-color-secondary)'],
            'danger' => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 18%, transparent)', 'color' => 'var(--xushi-color-danger)'],
            'success' => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 18%, transparent)', 'color' => 'var(--xushi-color-success)'],
            'warning' => ['background' => 'color-mix(in oklch, var(--xushi-color-warning) 18%, transparent)', 'color' => 'var(--xushi-color-warning)'],
            'info' => ['background' => 'color-mix(in oklch, var(--xushi-color-info) 18%, transparent)', 'color' => 'var(--xushi-color-info)'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
        ],
        'outline' => [
            'primary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-primary)', 'border' => '1px solid var(--xushi-color-primary)'],
            'secondary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-secondary)', 'border' => '1px solid var(--xushi-color-secondary)'],
            'danger' => ['background' => 'transparent', 'color' => 'var(--xushi-color-danger)', 'border' => '1px solid var(--xushi-color-danger)'],
            'success' => ['background' => 'transparent', 'color' => 'var(--xushi-color-success)', 'border' => '1px solid var(--xushi-color-success)'],
            'warning' => ['background' => 'transparent', 'color' => 'var(--xushi-color-warning)', 'border' => '1px solid var(--xushi-color-warning)'],
            'info' => ['background' => 'transparent', 'color' => 'var(--xushi-color-info)', 'border' => '1px solid var(--xushi-color-info)'],
            'base' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-base-border)'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['soft']['base'];

    $style = collect(array_merge([
        'padding' => $padding,
        'border-radius' => $radius,
        'gap' => $gap,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

@once
    <style>
        /* ── Badge ── */
        .xushi-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 500;
            white-space: nowrap;
            border-style: solid;
            border-width: 0;
            box-sizing: border-box;
        }

        .xushi-badge--sm { height: 1.25rem; font-size: 0.7rem;  padding: 0 0.4rem;   border-radius: var(--xushi-radius-selector); }
        .xushi-badge--md { height: 1.5rem;  font-size: 0.75rem; padding: 0 0.5rem;   border-radius: var(--xushi-radius-selector); }
        .xushi-badge--lg { height: 1.75rem; font-size: 0.8rem;  padding: 0 0.625rem; border-radius: var(--xushi-radius-selector); } 
            </style>   
@endonce

<span class="xushi-badge xushi-badge--{{ $size }}" style="{{ $style }}" {{ $attributes }}>
    @isset($iconslot)
        <span class="xushi-badge-icon">{{ $iconslot }}</span>
    @endisset

    <span>{{ $slot }}</span>
</span>

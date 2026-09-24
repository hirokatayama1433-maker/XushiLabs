@props([
    'variant' => 'soft',
    'color' => 'info',
    'padding' => '1rem',
    'radius' => 'var(--xushi-radius-box)',
    'shadow' => null,
    'gap' => '0.75rem',
    'margin' => null,
    'border' => '1px',
    'bordercolor' => null,
])

@php
    $variantStyles = [
        'solid' => [
            'danger' => ['background' => 'var(--xushi-color-danger)', 'color' => 'var(--xushi-color-danger-content)', 'border' => '0px'],
            'success' => ['background' => 'var(--xushi-color-success)', 'color' => 'var(--xushi-color-success-content)', 'border' => '0px'],
            'warning' => ['background' => 'var(--xushi-color-warning)', 'color' => 'var(--xushi-color-warning-content)', 'border' => '0px'],
            'info' => ['background' => 'var(--xushi-color-info)', 'color' => 'var(--xushi-color-info-content)', 'border' => '0px'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)', 'border' => '0px'],
        ],
        'soft' => [
            'danger' => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 14%, transparent)', 'color' => 'var(--xushi-color-danger)'],
            'success' => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 14%, transparent)', 'color' => 'var(--xushi-color-success)'],
            'warning' => ['background' => 'color-mix(in oklch, var(--xushi-color-warning) 18%, transparent)', 'color' => 'var(--xushi-color-warning)'],
            'info' => ['background' => 'color-mix(in oklch, var(--xushi-color-info) 16%, transparent)', 'color' => 'var(--xushi-color-info)'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
        ],
        'outline' => [
            'danger' => ['background' => 'transparent', 'color' => 'var(--xushi-color-danger)', 'border' => '1px solid var(--xushi-color-danger)'],
            'success' => ['background' => 'transparent', 'color' => 'var(--xushi-color-success)', 'border' => '1px solid var(--xushi-color-success)'],
            'warning' => ['background' => 'transparent', 'color' => 'var(--xushi-color-warning)', 'border' => '1px solid var(--xushi-color-warning)'],
            'info' => ['background' => 'transparent', 'color' => 'var(--xushi-color-info)', 'border' => '1px solid var(--xushi-color-info)'],
            'base' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-base-border)'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['soft']['info'];

    $style = collect(array_merge([
        'padding' => $padding,
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'gap' => $gap,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

@once
<style>
    .xushi-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.75rem 1rem;
        border-radius: var(--xushi-radius-box);
        border: var(--xushi-border-box) solid transparent;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .xushi-alert-content {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
        flex: 1;
        min-width: 0;
    }
</style>
@endonce

<div class="xushi-alert" style="{{ $style }}" {{ $attributes }}>
    @isset($iconslot)
        <span class="xushi-alert-icon">{{ $iconslot }}</span>
    @endisset

    <div class="xushi-alert-content">{{ $slot }}</div>

    @isset($trailing)
        <div class="xushi-alert-trailing">{{ $trailing }}</div>
    @endisset
</div>

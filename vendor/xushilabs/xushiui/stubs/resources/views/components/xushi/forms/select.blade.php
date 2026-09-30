@props([
    'variant' => 'outline',
    'color' => 'base',
    'disabled' => false,
    'padding' => '0 0.875rem',
    'radius' => 'var(--xushi-radius-field)',
    'shadow' => null,
    'margin' => null,
    'border' => 'var(--xushi-border-field)',
    'bordercolor' => 'var(--xushi-color-base-border)',
])

@php
    $variantStyles = [
        'outline' => [
            'base' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)'],
            'primary' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-primary)'],
            'success' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-success)'],
            'danger' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-danger)'],
        ],
        'soft' => [
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 10%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'success' => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 10%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'danger' => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 10%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['outline']['base'];

    $style = collect(array_merge([
        'padding' => $padding,
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
        '--xushi-input-focus-border' => $resolved['border-color'] ?? $bordercolor,
        'opacity' => $disabled ? '0.5' : null,
        'cursor' => $disabled ? 'not-allowed' : null,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<select class="xushi-input xushi-select" style="{{ $style }}" @disabled($disabled) {{ $attributes }}>
    {{ $slot }}
</select>

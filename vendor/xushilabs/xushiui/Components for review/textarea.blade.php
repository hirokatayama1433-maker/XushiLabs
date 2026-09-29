@props([
    'variant' => 'outline',
    'color' => 'base',
    'value' => null,
    'placeholder' => null,
    'rows' => 4,
    'disabled' => false,
    'padding' => '0.875rem',
    'radius' => 'var(--xushi-radius-field)',
    'shadow' => null,
    'margin' => null,
    'border' => 'var(--xushi-border-field)',
    'bordercolor' => 'var(--xushi-color-base-border)',
])

@once
<style>
    .xushi-textarea {
        display: block;
        width: 100%;
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
        font-family: inherit;
        line-height: 1.5;
        color: var(--xushi-color-base-content);
        background: var(--xushi-color-base-100);
        border: var(--xushi-border-field) solid var(--xushi-color-base-border);
        border-radius: var(--xushi-radius-field);
        resize: vertical;
        min-height: 80px;
        box-sizing: border-box;
        transition: border-color 150ms ease, box-shadow 150ms ease;
    }

    .xushi-textarea:focus {
        outline: none;
        border-color: var(--xushi-color-primary);
        box-shadow: 0 0 0 3px color-mix(in oklch, var(--xushi-color-primary) 20%, transparent);
    }

    .xushi-textarea::placeholder {
        color: var(--xushi-color-base-content);
        opacity: 0.4;
    }

    .xushi-textarea:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        resize: none;
    }
</style>
@endonce

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
        'border' => $border ? 'solid' : null,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
        '--xushi-input-focus-border' => $resolved['border-color'] ?? $bordercolor,
        'opacity' => $disabled ? '0.5' : null,
        'cursor' => $disabled ? 'not-allowed' : null,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<textarea
    class="xushi-input xushi-textarea"
    style="{{ $style }}"
    @if($placeholder !== null) placeholder="{{ $placeholder }}" @endif
    @disabled($disabled)
    rows="{{ $rows }}"
    {{ $attributes }}
>{{ $value ?? trim($slot) }}</textarea>

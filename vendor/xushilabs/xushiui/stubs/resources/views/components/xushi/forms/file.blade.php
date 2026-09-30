@props([
    'variant' => 'outline',
    'color' => 'base',
    'accept' => null,
    'multiple' => false,
    'disabled' => false,
    'padding' => '0.25rem',
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

    $resolved = $variantStyles[$variant][$color] ?? $variantStyles[$variant]['base'] ?? $variantStyles['outline']['base'];

    $style = collect(array_merge([
        'padding' => $padding,
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
        '--xushi-input-focus-border' => $resolved['border-color'] ?? $bordercolor,
        '--xushi-file-button-bg' => $resolved['background'] ?? 'var(--xushi-color-base-200)',
        '--xushi-file-button-color' => $resolved['color'] ?? 'var(--xushi-color-base-content)',
        '--xushi-file-button-border' => $resolved['border-color'] ?? $bordercolor,
        'opacity' => $disabled ? '0.5' : null,
        'cursor' => $disabled ? 'not-allowed' : null,
    ], $resolved))->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');
@endphp

@once
<style>
    .xushi-file {
        display: block;
        width: 100%;
        font-size: 0.875rem;
        font-family: inherit;
        color: var(--xushi-color-base-content);
        cursor: pointer;
    }

    .xushi-file::file-selector-button,
    .xushi-file::-webkit-file-upload-button {
        display: inline-flex;
        align-items: center;
        padding: 0 0.875rem;
        height: var(--xushi-size-field);
        font-size: 0.875rem;
        font-family: inherit;
        font-weight: 500;
        background: var(--xushi-color-base-200);
        color: var(--xushi-color-base-content);
        border: none;
        border-radius: var(--xushi-radius-field);
        margin-right: 0.75rem;
        cursor: pointer;
        transition: background 150ms ease;
    }

    .xushi-file:focus::file-selector-button,
    .xushi-file:focus::-webkit-file-upload-button {
        outline: 2px solid var(--xushi-color-primary);
        outline-offset: 2px;
    }
</style>
@endonce

<input
    class="xushi-input xushi-file"
    style="{{ $style }}"
    type="file"
    @if($accept !== null) accept="{{ $accept }}" @endif
    @if($multiple) multiple @endif
    @disabled($disabled)
    {{ $attributes }}
>

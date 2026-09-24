@props([
    'variant' => 'outline',
    'color' => 'primary',
    'checked' => false,
    'disabled' => false,
    'padding' => null,
    'radius' => 'var(--xushi-radius-selector)',
    'shadow' => null,
    'margin' => null,
    'border' => 'var(--xushi-border-selector)',
    'bordercolor' => 'var(--xushi-color-base-border)',
])

@once
<style>
    .xushi-radio {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        user-select: none;
    }

    .xushi-radio-box {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: var(--xushi-size-selector);
        height: var(--xushi-size-selector);
        border-radius: 50%;
        border: var(--xushi-border-selector) solid transparent;
        flex-shrink: 0;
        transition: background 120ms ease, border-color 120ms ease;
    }

    .xushi-radio-box input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        margin: 0;
    }

    .xushi-radio-dot {
        width: 38%;
        height: 38%;
        border-radius: 50%;
        background: currentColor;
        opacity: 0;
        transform: scale(0.4);
        transition: opacity 120ms ease, transform 120ms ease;
        pointer-events: none;
    }

    .xushi-radio-dot.is-on {
        opacity: 1;
        transform: scale(1);
    }
</style>
@endonce

@php
    $variantStyles = [
        'outline' => [
            'primary' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-primary)', 'border-color' => 'var(--xushi-color-primary)'],
            'base' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-base-border)'],
            'success' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-success)', 'border-color' => 'var(--xushi-color-success)'],
            'danger' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-danger)', 'border-color' => 'var(--xushi-color-danger)'],
            'warning' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-warning)', 'border-color' => 'var(--xushi-color-warning)'],
        ],
        'soft' => [
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 20%, transparent)', 'color' => 'var(--xushi-color-primary)', 'border-color' => 'transparent'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'success' => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 20%, transparent)', 'color' => 'var(--xushi-color-success)', 'border-color' => 'transparent'],
            'danger' => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 20%, transparent)', 'color' => 'var(--xushi-color-danger)', 'border-color' => 'transparent'],
            'warning' => ['background' => 'color-mix(in oklch, var(--xushi-color-warning) 20%, transparent)', 'color' => 'var(--xushi-color-warning)', 'border-color' => 'transparent'],
        ],
    ];

    $unchecked = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['outline']['primary'];

    $activeColors = [
        'base' => ['background' => 'var(--xushi-color-base-content)', 'color' => 'var(--xushi-color-base-100)'],
        'primary' => ['background' => 'var(--xushi-color-primary)', 'color' => 'var(--xushi-color-primary-content)'],
        'success' => ['background' => 'var(--xushi-color-success)', 'color' => 'var(--xushi-color-success-content)'],
        'danger' => ['background' => 'var(--xushi-color-danger)', 'color' => 'var(--xushi-color-danger-content)'],
        'warning' => ['background' => 'var(--xushi-color-warning)', 'color' => 'var(--xushi-color-warning-content)'],
    ];

    $checkedState = $activeColors[$color] ?? $activeColors['primary'];
    $uncheckedBackground = $unchecked['background'];
    $uncheckedColor = $unchecked['color'];
    $checkedBackground = $checkedState['background'];
    $checkedColor = $checkedState['color'];
    $resolved = $checked ? array_merge($unchecked, $checkedState) : $unchecked;

    $style = collect(array_merge([
        'padding' => $padding,
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
        'opacity' => $disabled ? '0.5' : null,
        'cursor' => $disabled ? 'not-allowed' : null,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<label class="xushi-radio" {{ $attributes->except(['class', 'style']) }}>
    <span
        class="xushi-radio-box"
        style="{{ $style }}"
        data-unchecked-bg="{{ $uncheckedBackground }}"
        data-unchecked-color="{{ $uncheckedColor }}"
        data-checked-bg="{{ $checkedBackground }}"
        data-checked-color="{{ $checkedColor }}"
    >
        <input
            type="radio"
            @checked($checked)
            @disabled($disabled)
            onchange="
                const box = this.parentElement;
                const dot = box.querySelector('.xushi-radio-dot');
                const on = this.checked;
                box.style.background = on ? box.dataset.checkedBg : box.dataset.uncheckedBg;
                box.style.color = on ? box.dataset.checkedColor : box.dataset.uncheckedColor;
                dot.classList.toggle('is-on', on);
            "
            {{ $attributes->only(['name', 'value', 'id']) }}
        >
        <span class="xushi-radio-dot {{ $checked ? 'is-on' : '' }}"></span>
    </span>
    <span class="xushi-radio-label">{{ $slot }}</span>
</label>

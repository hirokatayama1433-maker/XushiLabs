@props([
    'variant'      => 'solid',
    'color'        => 'primary',
    'size'         => 'md',
    'href'         => null,
    'icon'         => null,
    'iconTrailing' => null,
    'padding'      => null,
    'radius'       => null,
    'shadow'       => null,
    'gap'          => 'var(--xushi-gap-button)',
    'margin'       => null,
    'border'       => null,
    'bordercolor'  => null,
    'background'   => null,
    'textcolor'    => null,
    'fullwidth'    => false,
])

@php
    $sizeStyles = match($size) {
        'xs' => ['height' => '1.5rem', 'width' => 'min-content', 'font-size' => '0.75rem', 'padding' => '0 0.5rem', 'border-radius' => 'var(--xushi-radius-selector)'],
        'sm' => ['height' => '2rem', 'width' => 'min-content', 'font-size' => '0.875rem', 'padding' => '0 0.75rem', 'border-radius' => 'var(--xushi-radius-field)'],
        'md' => ['height' => '2.5rem', 'width' => 'min-content', 'font-size' => '0.875rem', 'padding' => '0 1rem', 'border-radius' => 'var(--xushi-radius-field)'],
        'lg' => ['height' => '3rem', 'width' => 'min-content', 'font-size' => '1rem', 'padding' => '0 1.25rem', 'border-radius' => 'var(--xushi-radius-field)'],
        'xl' => ['height' => '3.5rem', 'width' => 'min-content', 'font-size' => '1.125rem', 'padding' => '0 1.5rem', 'border-radius' => 'var(--xushi-radius-box)'],
        default => ['height' => '2.5rem', 'width' => 'min-content', 'font-size' => '0.875rem', 'padding' => '0 1rem', 'border-radius' => 'var(--xushi-radius-field)'],
    };

    $variantStyles = [
        'solid' => [
            'primary' => ['background' => 'var(--xushi-color-primary)', 'color' => 'var(--xushi-color-primary-content)'],
            'accent' => ['background' => 'var(--xushi-color-accent)', 'color' => 'var(--xushi-color-accent-content)'],
            'secondary' => ['background' => 'var(--xushi-color-secondary)', 'color' => 'var(--xushi-color-secondary-content)'],
            'danger' => ['background' => 'var(--xushi-color-danger)', 'color' => 'var(--xushi-color-danger-content)'],
            'success' => ['background' => 'var(--xushi-color-success)', 'color' => 'var(--xushi-color-success-content)'],
            'warning' => ['background' => 'var(--xushi-color-warning)', 'color' => 'var(--xushi-color-warning-content)'],
            'info' => ['background' => 'var(--xushi-color-info)', 'color' => 'var(--xushi-color-info-content)'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
        ],
        'soft' => [
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 15%, transparent)', 'color' => 'var(--xushi-color-primary)'],
            'secondary' => ['background' => 'color-mix(in oklch, var(--xushi-color-secondary) 15%, transparent)', 'color' => 'var(--xushi-color-secondary)'],
            'danger' => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 15%, transparent)', 'color' => 'var(--xushi-color-danger)'],
            'success' => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 15%, transparent)', 'color' => 'var(--xushi-color-success)'],
            'warning' => ['background' => 'color-mix(in oklch, var(--xushi-color-warning) 15%, transparent)', 'color' => 'var(--xushi-color-warning)'],
            'info' => ['background' => 'color-mix(in oklch, var(--xushi-color-info) 15%, transparent)', 'color' => 'var(--xushi-color-info)'],
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
        'ghost' => [
            'primary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-primary)'],
            'secondary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-secondary)'],
            'danger' => ['background' => 'transparent', 'color' => 'var(--xushi-color-danger)'],
            'success' => ['background' => 'transparent', 'color' => 'var(--xushi-color-success)'],
            'warning' => ['background' => 'transparent', 'color' => 'var(--xushi-color-warning)'],
            'info' => ['background' => 'transparent', 'color' => 'var(--xushi-color-info)'],
            'base' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)'],
        ],
        'link' => [
            'primary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-primary)', 'text-decoration' => 'underline'],
            'secondary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-secondary)', 'text-decoration' => 'underline'],
            'danger' => ['background' => 'transparent', 'color' => 'var(--xushi-color-danger)', 'text-decoration' => 'underline'],
            'success' => ['background' => 'transparent', 'color' => 'var(--xushi-color-success)', 'text-decoration' => 'underline'],
            'warning' => ['background' => 'transparent', 'color' => 'var(--xushi-color-warning)', 'text-decoration' => 'underline'],
            'info' => ['background' => 'transparent', 'color' => 'var(--xushi-color-info)', 'text-decoration' => 'underline'],
            'base' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'text-decoration' => 'underline'],
        ],
        'dashed' => [
            'primary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-primary)', 'border' => '1.5px dashed var(--xushi-color-primary)'],
            'secondary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-secondary)', 'border' => '1.5px dashed var(--xushi-color-secondary)'],
            'danger' => ['background' => 'transparent', 'color' => 'var(--xushi-color-danger)', 'border' => '1.5px dashed var(--xushi-color-danger)'],
            'success' => ['background' => 'transparent', 'color' => 'var(--xushi-color-success)', 'border' => '1.5px dashed var(--xushi-color-success)'],
            'warning' => ['background' => 'transparent', 'color' => 'var(--xushi-color-warning)', 'border' => '1.5px dashed var(--xushi-color-warning)'],
            'info' => ['background' => 'transparent', 'color' => 'var(--xushi-color-info)', 'border' => '1.5px dashed var(--xushi-color-info)'],
            'base' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1.5px dashed var(--xushi-color-base-border)'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['solid']['primary'];

    if ($background) $resolved['background'] = $background;
    if ($textcolor) $resolved['color'] = $textcolor;
    if ($padding) $sizeStyles['padding'] = $padding;
    if ($radius) $sizeStyles['border-radius'] = $radius;

    $style = collect(array_merge($sizeStyles, $resolved, [
        'gap' => $gap,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border' => $border ?? ($resolved['border'] ?? null),
        'width' => $fullwidth ? '100%' : ($sizeStyles['width'] ?? null),
    ]))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

@once
<style>
    .xushi-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        cursor: pointer;
        border: none;
        text-decoration: none;
        flex-shrink: 0;
        transition: filter 150ms ease, transform 100ms ease, box-shadow 150ms ease;
        white-space: nowrap;
        border-style: solid;
        border-width: 0;
        box-sizing: border-box;
    }
    .xushi-button:focus-visible {
        outline: 2px solid currentColor;
        outline-offset: 2px;
    }
    .xushi-button:not([disabled]):hover {
        filter: brightness(1.08);
    }
    .xushi-button:not([disabled]):active {
        transform: translateY(1px);
        filter: brightness(0.95);
    }
    .xushi-button[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
    .xushi-button-icon,
    .xushi-button-label,
    .xushi-button-trailing {
        display: inline-flex;
        align-items: center;
    }
</style>
@endonce

@php
    $tag = $href !== null ? 'a' : 'button';
    $iconTrailing = $iconTrailing ?? $attributes->get('icon:trailing');
    $hasLabel = trim((string) $slot) !== '';
    $hasLeadingIcon = $icon !== null || isset($iconslot);
    $hasTrailingIcon = $iconTrailing !== null || isset($trailing);
    $iconOnly = !$hasLabel && ($hasLeadingIcon || $hasTrailingIcon);
    $iconOnlyStyle = $iconOnly ? 'padding:0; min-width:0; aspect-ratio:1/1;' : '';
@endphp

<{{ $tag }}
    class="xushi-button"
    style="{{ $style }}{{ $iconOnlyStyle }}"
    @if($href !== null) href="{{ $href }}" @else type="button" @endif
    {{ $attributes->except(['icon', 'icon:trailing']) }}
>
    @if($icon !== null)
        <span class="xushi-button-icon"><xushi:icon name="{{ $icon }}" /></span>
    @elseif(isset($iconslot))
        <span class="xushi-button-icon">{{ $iconslot }}</span>
    @endif

    @if($hasLabel)
        <span class="xushi-button-label">{{ $slot }}</span>
    @endif

    @if($iconTrailing !== null)
        <span class="xushi-button-trailing"><xushi:icon :name="$iconTrailing" /></span>
    @elseif(isset($trailing))
        <span class="xushi-button-trailing">{{ $trailing }}</span>
    @endif
</{{ $tag }}>
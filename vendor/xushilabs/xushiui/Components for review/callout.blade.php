@props([
    'variant' => 'soft',
    'color' => 'info',
    'title' => null,
    'icon' => null,
    'padding' => '1rem 1.25rem',
    'radius' => 'var(--xushi-radius-box)',
    'shadow' => null,
    'margin' => null,
])

@php
    $tokens = [
        'info' => 'var(--xushi-color-info)',
        'success' => 'var(--xushi-color-success)',
        'warning' => 'var(--xushi-color-warning)',
        'danger' => 'var(--xushi-color-danger)',
        'base' => 'var(--xushi-color-base-content)',
    ];

    $accentToken = $tokens[$color] ?? $tokens['info'];

    $variantStyles = [
        'soft' => [
            'info' => ['background' => 'color-mix(in oklch, var(--xushi-color-info) 10%, transparent)', 'color' => 'var(--xushi-color-base-content)', 'border-left' => '3px solid var(--xushi-color-info)'],
            'success' => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 10%, transparent)', 'color' => 'var(--xushi-color-base-content)', 'border-left' => '3px solid var(--xushi-color-success)'],
            'warning' => ['background' => 'color-mix(in oklch, var(--xushi-color-warning) 14%, transparent)', 'color' => 'var(--xushi-color-base-content)', 'border-left' => '3px solid var(--xushi-color-warning)'],
            'danger' => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 10%, transparent)', 'color' => 'var(--xushi-color-base-content)', 'border-left' => '3px solid var(--xushi-color-danger)'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)', 'border-left' => '3px solid var(--xushi-color-base-border)'],
        ],
        'outline' => [
            'info' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-info)'],
            'success' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-success)'],
            'warning' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-warning)'],
            'danger' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-danger)'],
            'base' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-base-border)'],
        ],
        'solid' => [
            'info' => ['background' => 'var(--xushi-color-info)', 'color' => 'var(--xushi-color-info-content)'],
            'success' => ['background' => 'var(--xushi-color-success)', 'color' => 'var(--xushi-color-success-content)'],
            'warning' => ['background' => 'var(--xushi-color-warning)', 'color' => 'var(--xushi-color-warning-content)'],
            'danger' => ['background' => 'var(--xushi-color-danger)', 'color' => 'var(--xushi-color-danger-content)'],
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['soft']['info'];

    $iconColor = $variant === 'solid' ? ($resolved['color'] ?? 'currentColor') : $accentToken;

    $style = collect(array_merge([
        'padding' => $padding,
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'box-sizing' => 'border-box',
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

@once
<style>
    .xushi-callout {
        display: flex;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        border-radius: var(--xushi-radius-box);
        border-left: 3px solid currentColor;
        font-size: 0.875rem;
        line-height: 1.6;
    }
</style>
@endonce

{{-- existing blade HTML below --}}
<div class="xushi-callout xushi-callout--{{ $variant }} xushi-callout--{{ $color }}" style="{{ $style }}" {{ $attributes }}>
    <div style="display:flex; gap:0.75rem; align-items:flex-start;">

        @isset($iconslot)
            <span style="flex-shrink:0; color:{{ $iconColor }}; margin-top:0.125rem;">{{ $iconslot }}</span>
        @elseif($icon)
            <span style="flex-shrink:0; color:{{ $iconColor }}; margin-top:0.125rem;">
                <xushi:icon :name="$icon" size="1.125rem" />
            </span>
        @endisset

        <div style="flex:1; min-width:0;">
            @if($title)
                <p style="margin:0 0 0.25rem; font-size:0.9375rem; font-weight:600; line-height:1.4; color:inherit;">{{ $title }}</p>
            @endif

            <div style="font-size:0.875rem; line-height:1.6; color:inherit; opacity:{{ $title ? '0.85' : '1' }};">
                {{ $slot }}
            </div>
        </div>

        @isset($trailing)
            <div style="flex-shrink:0;">{{ $trailing }}</div>
        @endisset

    </div>
</div>

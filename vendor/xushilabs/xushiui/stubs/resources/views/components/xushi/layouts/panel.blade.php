@props([
    'colspan' => 1,
    'rowspan' => 1,
    'padding' => null,
    'background' => 'var(--xushi-color-base-foreground)',
    'border' => null,
    'shadow' => 'var(--xushi-shadow-sm)',
    'radius' => 'var(--xushi-radius-box)',
    'width' => null,
    'height' => null,
    'margin' => null,
    'overflow' => 'hidden',
])

@once('panel-base')
<style>
    .xushi-panel {
        min-width: 0;
        min-height: 0;
        display: flex;
        flex-direction: column;
    }
</style>
@endonce

@php
    $style = collect([
        'padding' => $padding ?? 'var(--xushi-spacing-md, 1.25rem)',
        'background-color' => $background,
        'border' => $border,
        'box-shadow' => $shadow,
        'width' => $width,
        'height' => $height,
        'margin' => $margin,
        'border-radius' => $radius,
        'overflow' => $overflow,
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div
    class="xushi-panel"
    data-panel
    data-colspan="{{ $colspan }}"
    data-rowspan="{{ $rowspan }}"
    style="{{ $style }}"
    {{ $attributes }}
>
    {{ $slot }}
</div>

@props([
    'orientation' => 'horizontal',
    'label' => null,
    'align' => 'center',
    'color' => 'var(--xushi-color-base-border)',
    'thickness' => '1px',
    'margin' => null,
    'spacing' => '1rem',
])

@php
    $isVertical = $orientation === 'vertical';

    $style = collect([
        'display' => 'flex',
        'align-items' => 'center',
        'flex-direction' => $isVertical ? 'column' : 'row',
        'gap' => $label ? $spacing : null,
        'margin' => $margin,
        'width' => $isVertical ? null : '100%',
        'height' => $isVertical ? '100%' : null,
        'min-height' => $isVertical ? '1rem' : null,
    ])->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');

    $lineStyle = collect([
        'flex' => '1',
        'border' => 'none',
        'background' => $color,
        'height' => $isVertical ? null : $thickness,
        'width' => $isVertical ? $thickness : null,
        'min-height' => $isVertical ? '1rem' : null,
        'min-width' => $isVertical ? null : '1rem',
    ])->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');

    $labelStyle = collect([
        'font-size' => '0.75rem',
        'font-weight' => '500',
        'color' => 'var(--xushi-color-base-content)',
        'opacity' => '0.5',
        'white-space' => 'nowrap',
        'flex-shrink' => '0',
    ])->map(fn($value, $key) => "$key: $value")->implode('; ');

    $hasLabel = $label !== null || $slot->isNotEmpty();
    $labelContent = $label ?? ($slot->isNotEmpty() ? $slot : null);
@endphp

<div
    role="separator"
    aria-orientation="{{ $orientation }}"
    class="xushi-separator xushi-separator--{{ $orientation }}"
    style="{{ $style }}"
    {{ $attributes }}
>
    @if(!$hasLabel)
        <span style="{{ $lineStyle }}"></span>
    @elseif($align === 'start')
        <span style="{{ $labelStyle }}">{{ $labelContent }}</span>
        <span style="{{ $lineStyle }}"></span>
    @elseif($align === 'end')
        <span style="{{ $lineStyle }}"></span>
        <span style="{{ $labelStyle }}">{{ $labelContent }}</span>
    @else
        <span style="{{ $lineStyle }}"></span>
        <span style="{{ $labelStyle }}">{{ $labelContent }}</span>
        <span style="{{ $lineStyle }}"></span>
    @endif
</div>

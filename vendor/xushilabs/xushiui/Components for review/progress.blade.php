@props([
    'value' => 0,
    'color' => 'primary',
    'showvalue' => false,
    'format' => 'percent',
])

@php
    $colors = [
        'primary' => 'var(--xushi-color-primary)',
        'secondary' => 'var(--xushi-color-secondary)',
        'danger' => 'var(--xushi-color-danger)',
        'success' => 'var(--xushi-color-success)',
        'warning' => 'var(--xushi-color-warning)',
        'info' => 'var(--xushi-color-info)',
        'base' => 'var(--xushi-color-base-content)',
    ];

    $barColor = $colors[$color] ?? $colors['primary'];
    $width = max(0, min(100, (int) $value));

    $style = collect([
        'width' => '100%',
        'height' => '8px',
        'border-radius' => '999px',
        'background' => 'var(--xushi-color-base-300)',
        'overflow' => 'hidden',
    ])->map(fn($value, $key) => "$key: $value")->implode('; ');

    $barStyle = collect([
        'height' => '100%',
        'width' => $width . '%',
        'border-radius' => '999px',
        'background' => $barColor,
        'transition' => 'width 300ms ease',
    ])->map(fn($value, $key) => "$key: $value")->implode('; ');
@endphp

<div style="display:flex; align-items:center; gap:0.5rem; width:100%;" {{ $attributes }}>
    <div style="{{ $style }}; flex:1;">
        <div style="{{ $barStyle }}"></div>
    </div>
    @if($showvalue)
        <span style="font-size:0.75rem; color:var(--xushi-color-base-content); opacity:0.7; white-space:nowrap; flex-shrink:0;">
            {{ $format === 'percent' ? $value . '%' : $value }}
        </span>
    @endif
</div>
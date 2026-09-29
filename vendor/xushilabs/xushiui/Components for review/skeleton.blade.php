@props([
    'variant' => 'line',
    'width' => null,
    'height' => null,
    'radius' => 'var(--xushi-radius-selector)',
    'margin' => null,
    'lines' => 1,
])

@php
    $defaults = [
        'line' => ['width' => '100%', 'height' => '1rem', 'border-radius' => $radius],
        'circle' => ['width' => '2.5rem', 'height' => '2.5rem', 'border-radius' => '999px'],
        'box' => ['width' => '100%', 'height' => '8rem', 'border-radius' => 'var(--xushi-radius-box)'],
        'text' => ['width' => '100%', 'height' => '1rem', 'border-radius' => $radius],
    ];

    $base = $defaults[$variant] ?? $defaults['line'];

    if ($width) {
        $base['width'] = $width;
    }

    if ($height) {
        $base['height'] = $height;
    }

    $style = collect(array_merge($base, [
        'margin' => $margin,
        'display' => 'block',
        'flex-shrink' => '0',
    ]))->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');
@endphp

@once
<style>
    .xushi-skeleton {
        position: relative;
        overflow: hidden;
        background: var(--xushi-color-base-200);
        border-radius: var(--xushi-radius-selector);
    }

    .xushi-skeleton::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            transparent 0%,
            color-mix(in oklch, var(--xushi-color-base-content) 6%, transparent) 50%,
            transparent 100%
        );
        animation: xushi-skeleton-shimmer 1.5s infinite;
    }

    @keyframes xushi-skeleton-shimmer {
        0%   { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
</style>
@endonce

@if($variant === 'text' && $lines > 1)
    <div style="display:flex; flex-direction:column; gap:0.5rem; {{ $margin ? 'margin:' . $margin . ';' : '' }}" {{ $attributes }}>
        @for($i = 0; $i < $lines; $i++)
            <span
                class="xushi-skeleton"
                style="{{ $style }}; {{ $i === $lines - 1 ? 'width:75%;' : '' }} margin:0;"
                aria-hidden="true"
            ></span>
        @endfor
    </div>
@else
    <span
        class="xushi-skeleton xushi-skeleton--{{ $variant }}"
        style="{{ $style }}"
        aria-hidden="true"
        {{ $attributes }}
    ></span>
@endif

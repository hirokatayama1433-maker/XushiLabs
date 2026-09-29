@props([
    'level' => '1',
    'size' => 'auto',
    'weight' => '700',
    'color' => 'var(--xushi-color-base-content)',
    'margin' => null,
    'align' => null,
    'muted' => false,
    'truncate' => false,
])

@php
    $tag = 'h' . $level;

    $autoSizes = [
        '1' => ['font-size' => '2rem', 'line-height' => '1.2', 'letter-spacing' => '-0.025em'],
        '2' => ['font-size' => '1.5rem', 'line-height' => '1.25', 'letter-spacing' => '-0.02em'],
        '3' => ['font-size' => '1.25rem', 'line-height' => '1.3', 'letter-spacing' => '-0.015em'],
        '4' => ['font-size' => '1.125rem', 'line-height' => '1.4', 'letter-spacing' => '-0.01em'],
        '5' => ['font-size' => '1rem', 'line-height' => '1.5', 'letter-spacing' => '0'],
        '6' => ['font-size' => '0.875rem', 'line-height' => '1.5', 'letter-spacing' => '0'],
    ];

    $explicitSizes = [
        'xs' => ['font-size' => '0.75rem', 'line-height' => '1.5'],
        'sm' => ['font-size' => '0.875rem', 'line-height' => '1.5'],
        'md' => ['font-size' => '1rem', 'line-height' => '1.5'],
        'lg' => ['font-size' => '1.125rem', 'line-height' => '1.4'],
        'xl' => ['font-size' => '1.25rem', 'line-height' => '1.3'],
        '2xl' => ['font-size' => '1.5rem', 'line-height' => '1.25'],
        '3xl' => ['font-size' => '2rem', 'line-height' => '1.2'],
    ];

    $sizing = $size === 'auto'
        ? ($autoSizes[$level] ?? $autoSizes['1'])
        : ($explicitSizes[$size] ?? $autoSizes[$level]);

    $style = collect(array_merge([
        'font-weight' => $weight,
        'color' => $muted ? 'var(--xushi-color-base-content-muted)' : $color,
        'margin' => $margin ?? '0',
        'text-align' => $align,
        'overflow' => $truncate ? 'hidden' : null,
        'text-overflow' => $truncate ? 'ellipsis' : null,
        'white-space' => $truncate ? 'nowrap' : null,
    ], $sizing))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

@once
<style>
    .xushi-heading {
        font-weight: 600;
        line-height: 1.25;
        color: var(--xushi-color-base-content);
    }
</style>
@endonce


<{{ $tag }} class="xushi-heading" style="{{ $style }}" {{ $attributes }}>{{ $slot }}</{{ $tag }}>

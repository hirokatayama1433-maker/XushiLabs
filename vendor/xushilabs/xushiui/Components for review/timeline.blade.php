@props([
    'variant' => 'left',
    'margin' => null,
])

@once
<style>
    .xushi-timeline {
        display: flex;
        flex-direction: column;
        position: relative;
    }
</style>
@endonce

@php
    $style = collect([
        'display' => 'flex',
        'flex-direction' => 'column',
        'width' => '100%',
        'margin' => $margin,
        'position' => 'relative',
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div
    class="xushi-timeline xushi-timeline--{{ $variant }}"
    style="{{ $style }}"
    {{ $attributes }}
>
    {{ $slot }}
</div>

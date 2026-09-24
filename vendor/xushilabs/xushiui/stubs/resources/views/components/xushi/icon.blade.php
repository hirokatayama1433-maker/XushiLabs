@props([
    'name' => null,
    'size' => '1em',
    'color' => null,
])

@php
    $paths = $name ? \Xushi\UI\Icons\IconMap::get($name) : null;
@endphp

@if ($paths)
@once
    <style>
        /* ── Icon Wrapper ── */
        .xushi-icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .xushi-icon-wrapper svg {
            width: 100%;
            height: 100%;
        }
    </style>
@endonce
<svg
    xmlns="http://www.w3.org/2000/svg"
    width="{{ $size }}"
    height="{{ $size }}"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="2"
    stroke-linecap="round"
    stroke-linejoin="round"
    @if($color) style="color: {{ $color }}" @endif
>
    {!! $paths !!}
</svg>
@endif

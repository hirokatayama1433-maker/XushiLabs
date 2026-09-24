@props([
    'href' => null,
    'current' => false,
    'xushi_breadcrumb_separator' => '/',
])

@php
    $sep = $xushi_breadcrumb_separator ?? '/';
@endphp

<li style="display:contents;">
    @if($current)
        <span
            aria-current="page"
            style="color:var(--xushi-color-base-content); opacity:0.5; font-weight:500;"
        >{{ $slot }}</span>
    @elseif($href)
        <a
            href="{{ $href }}"
            style="color:var(--xushi-color-base-content); opacity:0.6; text-decoration:none; transition:opacity 150ms ease;"
            onmouseover="this.style.opacity='1'"
            onmouseout="this.style.opacity='0.6'"
        >{{ $slot }}</a>

        <span aria-hidden="true" style="color:var(--xushi-color-base-content); opacity:0.3; user-select:none;">
            {{ $sep }}
        </span>
    @else
        <span style="color:var(--xushi-color-base-content); opacity:0.6;">{{ $slot }}</span>
        <span aria-hidden="true" style="color:var(--xushi-color-base-content); opacity:0.3; user-select:none;">
            {{ $sep }}
        </span>
    @endif
</li>

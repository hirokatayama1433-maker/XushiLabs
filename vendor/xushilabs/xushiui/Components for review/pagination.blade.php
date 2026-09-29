@props([
    'variant' => 'solid',
    'current' => 1,
    'total' => 1,
    'href' => null,
    'style' => null,
    'btnBase' => null,
    'pages' => [],
    'pageUrl' => fn ($page) => $href ? str_replace('{page}', $page, $href) : '#',
])

@php
    $variantActive = match($variant) {
        'solid'  => 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); border:1px solid transparent;',
        'ghost'  => 'background:color-mix(in oklch, var(--xushi-color-primary) 15%, transparent); color:var(--xushi-color-primary); border:1px solid transparent;',
        default  => 'background:var(--xushi-color-base-100); color:var(--xushi-color-primary); border:1px solid var(--xushi-color-primary);',
    };
    $variantDefault = match($variant) {
        'ghost'  => 'background:transparent; color:var(--xushi-color-base-content); border:1px solid transparent;',
        default  => 'background:var(--xushi-color-base-100); color:var(--xushi-color-base-content); border:1px solid var(--xushi-color-base-border);',
    };
    $variantHover = 'background:var(--xushi-color-base-200);';
@endphp

@once
<style>
    .xushi-pagination {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        flex-wrap: wrap;
    }
</style>
@endonce

@if($total > 1)
<nav
    aria-label="Pagination"
    x-data="{ current: {{ $current }} }"
    class="xushi-pagination"
    style="{{ $style }}"
    {{ $attributes }}
>
    {{-- Prev --}}
    @php($prevUrl = $href ? $pageUrl($current - 1) : '#')
    <{{ $href ? 'a' : 'button' }}
        @if($href) href="{{ $current > 1 ? $prevUrl : '#' }}" @else type="button" @endif
        @if(!$href) @click="current > 1 && (current--)" @endif
        aria-label="Previous page"
        style="{{ $btnBase }}; {{ $variantDefault }}; {{ $current <= 1 ? 'opacity:0.4; pointer-events:none; cursor:not-allowed;' : 'cursor:pointer;' }}"
        {{ $current <= 1 ? 'disabled' : '' }}
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" style="width:1rem;height:1rem;">
            <path d="m15 6-6 6 6 6"/>
        </svg>
    </{{ $href ? 'a' : 'button' }}>

    {{-- Pages --}}
    @foreach($pages as $page)
        @if($page === '...')
            <span style="{{ $btnBase }}; border:1px solid transparent; background:transparent; color:var(--xushi-color-base-content); opacity:0.4; cursor:default;">…</span>
        @else
            @php($isActive = $page === $current)
            @php($pageHref = $href ? $pageUrl($page) : '#')

            <{{ $href ? 'a' : 'button' }}
                @if($href) href="{{ $pageHref }}" @else type="button" @endif
                @if(!$href) @click="current = {{ $page }}" @endif
                aria-label="Page {{ $page }}"
                aria-current="{{ $isActive ? 'page' : 'false' }}"
                style="{{ $btnBase }}; {{ $isActive ? $variantActive : $variantDefault }}"
                @if(!$isActive)
                    onmouseover="this.style.background='var(--xushi-color-base-200)'"
                    onmouseout="this.style.background='{{ $variant === 'ghost' ? 'transparent' : 'var(--xushi-color-base-100)' }}'"
                @endif
            >{{ $page }}</{{ $href ? 'a' : 'button' }}>
        @endif
    @endforeach

    {{-- Next --}}
    @php($nextUrl = $href ? $pageUrl($current + 1) : '#')
    <{{ $href ? 'a' : 'button' }}
        @if($href) href="{{ $current < $total ? $nextUrl : '#' }}" @else type="button" @endif
        @if(!$href) @click="current < {{ $total }} && (current++)" @endif
        aria-label="Next page"
        style="{{ $btnBase }}; {{ $variantDefault }}; {{ $current >= $total ? 'opacity:0.4; pointer-events:none; cursor:not-allowed;' : 'cursor:pointer;' }}"
        {{ $current >= $total ? 'disabled' : '' }}
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" style="width:1rem;height:1rem;">
            <path d="m9 6 6 6-6 6"/>
        </svg>
    </{{ $href ? 'a' : 'button' }}>
</nav>
@endif

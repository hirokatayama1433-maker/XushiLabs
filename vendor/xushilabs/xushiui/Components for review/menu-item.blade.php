@props([
    'name' => null,
    'icon' => null,
    'href' => null,
    'color' => 'base',
    'active' => false,
    'disabled' => false,
])

@php
    $tag = $href ? 'a' : 'button';
    $colorMap = [
        'base' => 'var(--xushi-color-base-content)',
        'primary' => 'var(--xushi-color-primary)',
        'danger' => 'var(--xushi-color-danger)',
        'success' => 'var(--xushi-color-success)',
        'warning' => 'var(--xushi-color-warning)',
    ];
    $hoverBgMap = [
        'base' => 'var(--xushi-color-base-200)',
        'primary' => 'color-mix(in oklch, var(--xushi-color-primary) 12%, transparent)',
        'danger' => 'color-mix(in oklch, var(--xushi-color-danger) 10%, transparent)',
        'success' => 'color-mix(in oklch, var(--xushi-color-success) 10%, transparent)',
        'warning' => 'color-mix(in oklch, var(--xushi-color-warning) 10%, transparent)',
    ];
    $fg = $colorMap[$color] ?? $colorMap['base'];
    $hoverBg = $hoverBgMap[$color] ?? $hoverBgMap['base'];
    $hoverFg = $fg;
@endphp

@once
<style>
    .xushi-menu-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.4rem 0.5rem;
        border-radius: var(--xushi-radius-field);
        border: none;
        background: transparent;
        font-size: 0.875rem;
        font-family: inherit;
        text-decoration: none;
        cursor: pointer;
        box-sizing: border-box;
        text-align: left;
        transition: background 120ms ease, color 120ms ease;
        white-space: nowrap;
    }

    .xushi-menu-item:disabled,
    .xushi-menu-item[data-disabled] {
        opacity: 0.45;
        pointer-events: none;
        cursor: not-allowed;
    }

    .xushi-menu-item-icon {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 1.25rem;
        height: 1.25rem;
        opacity: 0.75;
    }

    .xushi-menu-item-label {
        flex: 1;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endonce

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if($tag === 'button') type="button" @endif
    @if($disabled) disabled data-disabled @endif
    {{ $attributes->except('class') }}
    class="xushi-menu-item"
    style="color:{{ $fg }};"
    @unless($disabled)
        onmouseover="this.style.background='{{ $hoverBg }}'; this.style.color='{{ $hoverFg }}';"
        onmouseout="this.style.background='transparent'; this.style.color='{{ $fg }}';"
    @endunless
>
    @if($icon)
        <span class="xushi-menu-item-icon">
            <xushi:icon name="{{ $icon }}" size="15px" />
        </span>
    @endif

    @if($name !== null)
        <span class="xushi-menu-item-label">{{ $name }}</span>
    @elseif($slot->isNotEmpty())
        <span class="xushi-menu-item-label">{{ $slot }}</span>
    @endif

    {{-- Optional right slot (shortcut hint, badge, arrow, etc.) --}}
    @isset($right)
        <span style="flex-shrink:0; opacity:0.5; font-size:0.75rem; display:flex; align-items:center;">
            {{ $right }}
        </span>
    @endisset
</{{ $tag }}>
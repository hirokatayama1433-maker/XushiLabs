@props([
    'href' => null,
    'active' => false,
    'background' => null,
    'color' => null,
    'radius' => null,
    'padding' => null,
    'accent' => null,
    'icon' => null,
    'name' => null,
    'badge' => null,
])

@once
<style>
    .xushi-navitem-badge {
        max-width: 20rem;
        overflow: hidden;
        transition: opacity 200ms ease-in-out;
        background: var(--xushi-color-red-500);
    }

    .xushi-navitem-badge-ping {
        position: absolute;
        top: 3px;
        right: 3px;
        width: 7px;
        height: 7px;
        border: 2px solid var(--xushi-custom-sidebar-bg);
        border-radius: 50%;
        background: var(--xushi-color-red-500);
        opacity: 0;
        pointer-events: none;
        transition: opacity 200ms ease-in-out;
    }

    html.sidebar-collapsed .xushi-navitem-badge-full {
        position: absolute;
        top: 3px;
        right: 3px;
        opacity: 0;
    }

    html.sidebar-collapsed .xushi-navitem-badge-ping {
        opacity: 1;
        z-index: 1;
    }
</style>
<script>
    window.xushiTooltip ??= function xushiTooltip() {
        return {
            open: false,
            init() {
                window.addEventListener('xushi:sidebar-toggled', () => {
                    this.open = false;
                });
            },
            show(trigger, panel) {
                this.open = true;
                this.$nextTick(() => xushiPosition(trigger, panel));
            },
            hide() {
                this.open = false;
            },
        };
    };

    document.addEventListener('alpine:init', () => {
        if (typeof Alpine === 'undefined') return;
        Alpine.data('xushiTooltip', window.xushiTooltip);
    });
</script>
@endonce

@php
    $tag = $href !== null ? 'a' : 'button';
@endphp

@php
    $bg = $background ?? ($active ? 'var(--xushi-color-base-foreground)' : 'var(--xushi-color-sidebar)');
    $fg = $color ?? ($active ? 'var(--xushi-color-primary)' : 'var(--xushi-color-base-content)');
    $rad = $radius ?? 'var(--xushi-radius-field)';
    $pad = $padding ?? '0px';
    $accentColor = $accent ?? 'var(--xushi-color-primary)';
    $baseStyle = "
        height: 36px;
        display: flex;
        align-items: center;
        width: 100%;
        border-radius: {$rad};
        cursor: pointer;
        transition: background 150ms ease, color 150ms ease;
        text-decoration: none;
        border: none;
        box-sizing: border-box;
        font-family: inherit;
        padding: {$pad};
        background: {$bg};
        color: {$fg};
    ";
    $hoverBg = $background ?? 'var(--xushi-color-base-foreground)';
    $hoverColor = $color ?? 'var(--xushi-color-base-content)';
@endphp

<div
    x-data="xushiTooltip()"
    @class(['xushi-navitem-no-icon' => !$icon])
    style="position:relative; overflow:visible;"
>
    <{{ $tag }}
        @if($href) href="{{ $href }}" @endif
        @if($tag === 'button') type="button" @endif
        onclick="Xushi.Sidebar.closeMobile()"
        {{ $attributes->except('class') }}
        style="{{ $baseStyle }}"
        x-ref="trigger"
        x-on:mouseenter="
            if (document.documentElement.classList.contains('sidebar-collapsed')) {
                show($refs.trigger, $refs.panel);
            }
        "
        x-on:mouseleave="hide()"
        @if(!$active)
            onmouseover="this.style.background='{{ $hoverBg }}'; this.style.color='{{ $hoverColor }}';"
            onmouseout="this.style.background='{{ $background ?? 'var(--xushi-color-sidebar)' }}'; this.style.color='{{ $color ?? 'var(--xushi-color-base-content)' }}';"
        @endif
    >
        {{-- Icon --}}  
        @if($icon)
            <div style="width:40px; height:40px; display:flex; justify-content:center; align-items:center; flex-shrink:0;">
                <xushi:icon name="{{ $icon }}" size="18px"/>
            </div>
        @endif

        {{-- Label text — hides on collapse --}}
        <span class="xushi-sb-text" style="font-size:14px; flex:1; min-width:0; overflow:hidden; text-overflow:ellipsis; text-align:start;">
            @if($name !== null)
                {{ $name }}
            @else
                {{ $slot }}
            @endif
        </span>

        {{-- Badge — becomes a ping on collapse --}}
        @if($badge)
            <span
                class="xushi-navitem-badge xushi-navitem-badge-full"
                style="
                    transition: opacity 100ms ease-in-out;
                    flex-shrink:0;
                    font-size:0.65rem;
                    font-weight:600;
                    line-height:1;
                    padding:0.2rem 0.4rem;
                    border-radius:9999px;
                    color:var(--xushi-color-primary-content);
                    margin-right:0.5rem;
                    white-space:nowrap;
                "
            >{{ $badge }}</span>
            <span class="xushi-navitem-badge-ping" aria-hidden="true"></span>
        @endif

        {{-- Optional right-icon slot — hides on collapse --}}
        @isset($righticon)
            <div class="xushi-sb-text" style="width:36px; height:36px; display:flex; justify-content:center; align-items:center; flex-shrink:0;">
                {{ $righticon }}
            </div>
        @endisset
    </{{ $tag }}>

    {{-- Collapsed tooltip --}}
    <div
        x-show="open && document.documentElement.classList.contains('sidebar-collapsed')"
        x-cloak
        x-ref="panel"
        x-bind:class="open ? 'xushi-dropdown-enter' : 'xushi-dropdown-leave'"
        data-xushi-placement="right-center"
        style="
            position: fixed;
            z-index: var(--xushi-z-tooltip);
            background: var(--xushi-color-sidebar);
            color: var(--xushi-color-base-content);
            border: 1px solid var(--xushi-color-base-neutral);
            padding: 0.25rem 0.625rem;
            border-radius: var(--xushi-radius-field);
            font-size: 0.8rem;
            white-space: nowrap;
            pointer-events: none;
            box-shadow: var(--xushi-shadow);
        "
    >{{ $name ?? $slot }}</div>
</div>

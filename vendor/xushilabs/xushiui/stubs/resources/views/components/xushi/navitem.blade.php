@props([
    'href' => null,
    'active' => false,
    'color' => null,
    'lefticon' => null,
    'righticon' => null,
    'background' => null,
    'baseStyle' => null,
    'hoverBg' => null,
    'hoverColor' => null,
])

@php($tag = $href !== null ? 'a' : 'button')

<div
    x-data="xushiTooltip()"
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
            onmouseout="this.style.background='{{ $background ?? 'var(--xushi-custom-sidebar-item-bg)' }}'; this.style.color='{{ $color ?? 'var(--xushi-custom-sidebar-content)' }}';"
        @endif
    >
        @isset($lefticon)
            <div style="width:36px; height:36px; display:flex; justify-content:center; align-items:center; flex-shrink:0;">
                {{ $lefticon }}
            </div>
        @endisset

        <span class="sidebar-label" style="font-size:14px; flex:1; min-width:0; overflow:hidden; text-overflow:ellipsis; text-align:start;">
            {{ $slot }}
        </span>

        @isset($righticon)
            <div class="sidebar-label" style="width:36px; height:36px; display:flex; justify-content:center; align-items:center; flex-shrink:0;">
                {{ $righticon }}
            </div>
        @endisset
    </{{ $tag }}>

    <template x-teleport="body">
        <div
            x-show="open && document.documentElement.classList.contains('sidebar-collapsed')"
            x-cloak
            x-ref="panel"
            x-bind:class="open ? 'xushi-dropdown-enter' : 'xushi-dropdown-leave'"
            data-xushi-placement="right-center"
            style="
                position: fixed;
                z-index: var(--xushi-z-tooltip);
                background: var(--xushi-color-base-200);
                color: var(--xushi-color-base-content);
                padding: 0.25rem 0.625rem;
                border-radius: var(--xushi-radius-field);
                font-size: 0.8rem;
                white-space: nowrap;
                pointer-events: none;
                box-shadow: var(--xushi-shadow);
                border: 1px solid var(--xushi-color-base-border);
            "
        >{{ $slot }}</div>
    </template>
</div>

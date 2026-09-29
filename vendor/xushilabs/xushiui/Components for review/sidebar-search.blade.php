@once
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

@props([
    'placeholder' => 'Search...',
    'kbd'         => null,
    'icon'        => 'search',
])

@php
    $tooltipLabel = $kbd ? $placeholder . ' (' . $kbd . ')' : $placeholder;
@endphp

@once
    <style>
        .xushi-sidebar-search:focus-within {
            border-color: var(--xushi-color-primary);
        }

        .xushi-sidebar-search input::placeholder {
            font-size: 0.75rem;
            color: var(--xushi-custom-sidebar-content);
            opacity: 0.5;
        }

        html.sidebar-collapsed .xushisidebar[data-collapse="viewicons"] .xushi-sidebar-search {
            height: 36px !important;
            cursor: pointer;
        }

        html.sidebar-collapsed .xushisidebar[data-collapse="viewicons"] .xushi-sidebar-search:hover {
            background: var(--xushi-custom-sidebar-item-bg-hover) !important;
        }

        html.sidebar-mobile-open .xushi-sidebar-search {
            height: 34px !important;
            cursor: text !important;
        }
    </style>
@endonce

<div
    x-data="xushiTooltip()"
    class="xushi-sidebar-search-group"
    style="position:relative; overflow:visible; width:100%;"
>
    <div
        class="xushi-sidebar-search"
        x-ref="trigger"
        style="
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            height: 36px;
            box-sizing: border-box;
            padding: 0 0.680rem;
            border-radius: var(--xushi-radius-field);
            border: 1px solid var(--xushi-color-base-neutral);
            background: var(--xushi-color-sidebar);
            color: var(--xushi-color-base-content);
            transition: border-color 150ms ease, background 150ms ease;
            cursor: text;
        "
        x-on:mouseenter="
            if (document.documentElement.classList.contains('sidebar-collapsed')) {
                show($refs.trigger, $refs.panel);
            }
        "
        x-on:mouseleave="hide()"
        onclick="
            if (document.documentElement.classList.contains('sidebar-collapsed')) {
                Xushi.Sidebar.expand();
                var field = this;
                setTimeout(function () {
                    field.querySelector('[data-xushi-search-field]')?.focus();
                }, 220);
            }
        "
    >
        <span style="flex-shrink:0; display:flex; opacity:0.8;">
            <xushi:icon :name="$icon" size="1rem" />
        </span>

        <input
            type="text"
            class="xushi-sb-text"
            placeholder="{{ $placeholder }}"
            data-xushi-search-field
            style="
                flex: 1;
                min-width: 0;
                height: 100%;
                border: none;
                outline: none;
                background: transparent;
                font-size: 14px;
                color: var(--xushi-color-base-content);
                padding: 0;
            "
            {{ $attributes->except('class') }}
        >

        @if($kbd)
            <kbd
                class="xushi-sb-text"
                style="
                    flex-shrink: 0;
                    font-size: 0.7rem;
                    line-height: 1;
                    padding: 0.2rem 0.375rem;
                    border-radius: calc(var(--xushi-radius-field) - 2px);
                    border: 1px solid var(--xushi-color-base-neutral);
                    color: var(--xushi-color-base-content);
                    opacity: 0.6;
                "
            >{{ $kbd }}</kbd>
        @endif
    </div>

    <div
        x-show="open && document.documentElement.classList.contains('sidebar-collapsed')"
        x-cloak
        x-ref="panel"
        x-bind:class="open ? 'xushi-dropdown-enter' : 'xushi-dropdown-leave'"
        data-xushi-placement="right-center"
        style="
            position: fixed;
            z-index: var(--xushi-z-tooltip);
            background: var(--xushi-color-base-foreground);
            color: var(--xushi-color-base-content);
            padding: 0.25rem 0.625rem;
            border-radius: var(--xushi-radius-field);
            font-size: 0.8rem;
            white-space: nowrap;
            pointer-events: none;
            box-shadow: var(--xushi-shadow);
        "
    >{{ $tooltipLabel }}</div>
</div>
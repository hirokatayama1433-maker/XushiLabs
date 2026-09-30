@props([
    'text' => 'Tooltip',
    'padding' => '0.5rem 0.75rem',
    'radius' => 'var(--xushi-radius-selector)',
    'shadow' => 'var(--xushi-shadow)',
    'background' => 'var(--xushi-color-base-100)',
    'color' => 'var(--xushi-color-base-content)',
])

@once
<style>
    .xushi-tooltip-root {
        position: relative;
        display: inline-flex;
    }

    .xushi-tooltip-panel {
        position: fixed;
        z-index: var(--xushi-z-tooltip);
        background: var(--xushi-color-base-900);
        color: var(--xushi-color-base-100);
        font-size: 0.75rem;
        line-height: 1.4;
        padding: 0.375rem 0.625rem;
        border-radius: var(--xushi-radius-selector);
        white-space: nowrap;
        pointer-events: none;
        box-shadow: var(--xushi-shadow);
        max-width: 220px;
        white-space: normal;
    }
</style>
@endonce

@once
<script>
    function xushiTooltip() {
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
            hide() { this.open = false; },
        };
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('xushiTooltip', xushiTooltip);
    });
</script>
@endonce

@php
    $style = collect([
        'padding' => $padding,
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'background' => $background,
        'color' => $color,
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div
    x-data="xushiTooltip()"
    class="xushi-tooltip-root"
    x-on:mouseenter="show($refs.trigger, $refs.panel)"
    x-on:mouseleave="hide()"
    {{ $attributes->except(['class', 'style']) }}
>
    @isset($trigger)
        <div x-ref="trigger">{{ $trigger }}</div>
    @endisset

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-ref="panel"
            @keydown.window.escape="if (open) hide()"
            x-bind:class="open ? 'xushi-dropdown-enter' : 'xushi-dropdown-leave'"
            style="position:fixed; z-index:var(--xushi-z-tooltip); {{ $style }}"
        >
            {{ $slot->isNotEmpty() ? $slot : $text }}
        </div>
    </template>
</div>

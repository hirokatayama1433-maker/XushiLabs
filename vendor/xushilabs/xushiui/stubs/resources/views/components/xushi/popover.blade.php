@props([
    'padding'     => '1rem',
    'radius'      => 'var(--xushi-radius-box)',
    'shadow'      => 'var(--xushi-shadow)',
    'background'  => 'var(--xushi-color-base-background)',
    'minwidth'    => '16rem',
    'margin'      => null,
    'border'      => '1px',
    'bordercolor' => 'var(--xushi-color-base-neutral)',
])

@once
<style>
    .xushi-popover-panel {
        position: fixed;
        z-index: var(--xushi-z-popover);
        background: var(--xushi-color-base-foreground);
        border: var(--xushi-border-box) solid var(--xushi-color-base-neutral);
        border-radius: var(--xushi-radius-box);
        box-shadow: var(--xushi-shadow);
        box-sizing: border-box;
    }

    html.sidebar-collapsed .xushi-popover-panel .xushi-sb-text {
        opacity: 1;
        max-width: none;
        pointer-events: auto;
    }
</style>
@endonce

@once
<script>
    function xushiPopover() {
        return {
            open: false,
            _id: null,
            _reposition: null,

            startReposition(trigger, panel) {
                this.stopReposition();
                this._reposition = () => xushiPosition(trigger, panel);
                window.addEventListener('scroll', this._reposition, { passive: true, capture: true });
                window.addEventListener('resize', this._reposition, { passive: true });
            },

            stopReposition() {
                if (!this._reposition) return;
                window.removeEventListener('scroll', this._reposition, { capture: true });
                window.removeEventListener('resize', this._reposition);
                this._reposition = null;
            },

            toggle(trigger, panel) {
                if (this.open) { this.hide(); return; }
                this._id = Symbol();
                XushiOverlayStack.push({ id: this._id, type: 'positioned', hide: () => this.hide() });
                this.open = true;
                this.$nextTick(() => {
                    xushiPosition(trigger, panel);
                    this.startReposition(trigger, panel);
                });
            },

            hide() {
                this.open = false;
                this.stopReposition();
                if (this._id) {
                    XushiOverlayStack.pop(this._id);
                    this._id = null;
                }
            },
        };
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('xushiPopover', xushiPopover);
    });
</script>
@endonce

@php
    $panelStyle = collect([
        'padding'      => $padding,
        'border-radius'=> $radius,
        'box-shadow'   => $shadow,
        'background'   => $background,
        'min-width'    => $minwidth,
        'margin'       => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
        'border-style' => $border ? 'solid' : null,
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div x-data="xushiPopover()" class="xushi-popover-root" {{ $attributes->except(['class', 'style']) }}>
    @isset($trigger)
        <div x-ref="trigger" x-on:click="toggle($refs.trigger, $refs.panel)">{{ $trigger }}</div>
    @endisset

    <template x-teleport="body">
        <div
            class="xushi-popover-panel"
            x-show="open"
            x-cloak
            x-ref="panel"
            @keydown.window.escape="if (open) hide()"
            x-on:click.outside="if ($refs.trigger && $refs.trigger.contains($event.target)) return; hide()"
            x-on:click.stop
            x-bind:class="open ? 'xushi-dropdown-enter' : 'xushi-dropdown-leave'"
            style="{{ $panelStyle }}"
        >
            {{ $slot }}
        </div>
    </template>
</div>
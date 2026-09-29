@props([
    'position' => 'left',
    'width' => null,
    'height' => null,
    'padding' => null,
    'shadow' => null,
])

@php
    $enterClass = 'xushi-drawer-enter-' . $position;
    $leaveClass = 'xushi-drawer-leave-' . $position;
@endphp

@once
<style>
    .xushi-drawer-panel {
        position: fixed;
        z-index: var(--xushi-z-drawer);
        background: var(--xushi-color-base-100);
        overflow-y: auto;
        box-sizing: border-box;
        pointer-events: all;
        box-shadow: var(--xushi-shadow);
        padding: 1.5rem;
    }

    .xushi-drawer-panel--left {
        top: 0;
        left: 0;
        height: 100%;
        width: 320px;
        max-width: 90vw;
    }

    .xushi-drawer-panel--right {
        top: 0;
        right: 0;
        height: 100%;
        width: 320px;
        max-width: 90vw;
    }

    .xushi-drawer-panel--top {
        top: 0;
        left: 0;
        width: 100%;
        height: 320px;
        max-height: 90vh;
    }

    .xushi-drawer-panel--bottom {
        bottom: 0;
        left: 0;
        width: 100%;
        height: 320px;
        max-height: 90vh;
    }
</style>
@endonce

@once
<script>
    function xushiDrawer() {
        return {
            open: false,
            _id: null,

            show() {
                this._id = Symbol();
                XushiOverlayStack.push({ id: this._id, type: 'blocking', hide: () => this.hide() });
                this.open = true;
            },

            hide() {
                this.open = false;
                if (this._id) {
                    XushiOverlayStack.pop(this._id);
                    this._id = null;
                }
            },
        };
    }

    window.xushiDrawer = xushiDrawer;

    document.addEventListener('alpine:init', () => {
        Alpine.data('xushiDrawer', xushiDrawer);
    });
</script>
@endonce

<div x-data="xushiDrawer()" style="display:contents;" {{ $attributes->except(['class', 'style']) }}>
    @isset($trigger)
        <div style="display:inline-flex;" x-on:click="show()">
            {{ $trigger }}
        </div>
    @endisset

    <template x-teleport="body">
        <div x-show="open" x-cloak @keydown.window.escape="if (open) hide()" style="position:fixed; inset:0; z-index:var(--xushi-z-drawer); display:none;">

            {{-- Backdrop --}}
            <div
                x-on:click="hide()"
                x-bind:class="open ? 'xushi-backdrop-enter' : 'xushi-backdrop-leave'"
                style="position:absolute; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);"
            ></div>

            {{-- Panel --}}
            <div
                x-on:click.stop
                x-bind:class="open ? '{{ $enterClass }}' : '{{ $leaveClass }}'"
                class="xushi-drawer-panel xushi-drawer-panel--{{ $position }}"
                style="
                    {{ $width   ? 'width: '      . $width   . ';' : '' }}
                    {{ $height  ? 'height: '     . $height  . ';' : '' }}
                    {{ $padding ? 'padding: '    . $padding . ';' : '' }}
                    {{ $shadow  ? 'box-shadow: ' . $shadow  . ';' : '' }}
                "
            >
                {{ $slot }}
            </div>
        </div>
    </template>
</div>

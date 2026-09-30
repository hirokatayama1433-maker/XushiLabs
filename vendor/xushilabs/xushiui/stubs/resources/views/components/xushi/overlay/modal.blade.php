@props([
    'size' => 'md',
    'width' => null,
    'height' => null,
    'closeOnOutside' => true,
    'padding' => null,
    'radius' => null,
    'shadow' => null,
])

@php
    $closeOnOutside = filter_var($closeOnOutside, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;

    $widths = [
        'xs' => 'clamp(15rem, 30vw, 30vw)',
        'sm' => 'clamp(20rem, 50vw, 50vw)',
        'md' => 'clamp(22rem, 70vw, 70vw)',
        'lg' => 'clamp(24rem, 90vw, 90vw)',
        'auto' => 'fit-content',
    ];

    $heights = [
        'xs' => 'min(60dvh, calc(100dvh - 2rem))',
        'sm' => 'min(70dvh, calc(100dvh - 2rem))',
        'md' => 'min(80dvh, calc(100dvh - 2rem))',
        'lg' => 'min(88dvh, calc(100dvh - 2rem))',
        'auto' => 'calc(100dvh - 2rem)',
    ];

    $widthValue = $widths[$size] ?? $widths['md'];
    $maxHeight = $heights[$size] ?? $heights['md'];
    $resolvedWidth = $width ?? $widthValue;
    $resolvedHeight = $height;
    $resolvedMaxHeight = $height ?? $maxHeight;

    $style = collect([
        '--xushi-modal-width' => $resolvedWidth,
        '--xushi-modal-max-height' => $resolvedMaxHeight,
        'width' => $resolvedWidth,
        'height' => $resolvedHeight,
        'max-height' => $resolvedMaxHeight,
        'padding' => $padding ?? '1.5rem',
        'border-radius' => $radius ?? 'var(--xushi-radius-box)',
        'box-shadow' => $shadow ?? 'var(--xushi-shadow)',
    ])->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');
@endphp

@once
<style>
    .xushi-modal-panel {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: auto;
        background: var(--xushi-color-base-background);
        box-sizing: border-box;
        max-width: calc(100vw - 2rem);
        border: var(--xushi-border-box) solid var(--xushi-color-base-neutral);
    }
</style>
@endonce

@once
<script>
    function xushiModal() {
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

    document.addEventListener('alpine:init', () => {
        Alpine.data('xushiModal', xushiModal);
    });
</script>
@endonce

<div
    x-data="xushiModal()"
    class="xushi-modal-root"
    {{ $attributes->except(['class', 'style']) }}
>
    @isset($trigger)
        <div x-on:click="show()">{{ $trigger }}</div>
    @endisset

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            @keydown.window.escape="if (open) hide()"
            style="position: fixed; inset: 0; z-index: var(--xushi-z-modal);"
        >
            {{-- Backdrop --}}
            <div
                @if($closeOnOutside) x-on:click="hide()" @endif
                x-bind:class="open ? 'xushi-backdrop-enter' : 'xushi-backdrop-leave'"
                style="position: absolute; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);"
            ></div>

            {{-- Panel --}}
            <div
                x-on:click.stop
                x-bind:class="open ? 'xushi-modal-enter' : 'xushi-modal-leave'"
                class="xushi-modal-panel"
                style="{{ $style }}"
            >
                {{ $slot }}
            </div>
        </div>
    </template>
</div>

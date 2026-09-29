@props([
    'default' => '',
    'orientation' => 'horizontal',
    'variant' => 'underline',
    'color' => null,
    'radius' => null,
    'muted' => false,
    'fill' => false,
    'scrollable' => false,
    'sticky' => false,
    'stickyoffset' => '0px',
    'width' => null,
    'height' => null,
    'maxheight' => null,
    'maxwidth' => null,
    'background' => null,
    'panelradius' => null,
    'panelpadding' => null,
    'margin' => null,
    'border' => null,
    'defaultopen' => '',
    'title' => null,
])

@once
<style>
    /* Root — must stretch children to equal height in vertical mode */
    .xushi-tab {
        align-items: stretch;
        height: 100%
    }

    .xushi-tab-list {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        flex-shrink: 0;
    }

    .xushi-tab-header {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        min-width: 0;
        overflow: visible;
    }

    .xushi-tab-titlebar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        min-width: 0;
    }

    .xushi-tab-title {
        flex-shrink: 0;
        font-weight: 600;
    }

    .xushi-tab-footer {
        flex-shrink: 0;
    }

    .xushi-tab-item {
        display: inline-flex;
        align-items: center;
        justify-content: start;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: var(--xushi-radius-selector);
        cursor: pointer;
        white-space: nowrap;
        transition: background 150ms ease, color 150ms ease, box-shadow 150ms ease;
        border: none;
        background: transparent;
        color: var(--xushi-color-base-content);
        text-decoration: none;
    }

    .xushi-tab-item:hover {
        background: color-mix(in oklch, var(--xushi-color-base-content) 8%, transparent);
    }

    .xushi-tab-item[disabled] {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ── underline ── */
    .xushi-tab-list--underline {
        border-bottom: 2px solid var(--xushi-color-base-border);
        gap: 0;
        border-radius: 0;
        overflow: visible;
        padding-bottom: 2px;
        margin-bottom: -2px;
    }

    .xushi-tab-list--underline .xushi-tab-item {
        border-radius: 0;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .xushi-tab-list--underline .xushi-tab-item.is-active {
        border-bottom-color: var(--xushi-tab-accent);
        color: var(--xushi-tab-accent);
    }

    /* ── pill ── */
    .xushi-tab-list--pill .xushi-tab-item {
        border-radius: 9999px;
    }

    .xushi-tab-list--pill .xushi-tab-item.is-active {
        background: var(--xushi-tab-accent);
        color: var(--xushi-color-primary-content);
    }

    .xushi-tab-list--pill.xushi-tab-list--muted .xushi-tab-item:not(.is-active) {
        color: var(--xushi-color-base-content);
        opacity: 0.6;
    }

    /* ── soft ── */
    .xushi-tab-list--soft .xushi-tab-item.is-active {
        background: color-mix(in oklch, var(--xushi-tab-accent) 15%, transparent);
        color: var(--xushi-tab-accent);
    }

    .xushi-tab-list--soft.xushi-tab-list--muted .xushi-tab-item:not(.is-active) {
        color: var(--xushi-color-base-content);
        opacity: 0.6;
    }

    /* ── solid ── */
    .xushi-tab-list--solid .xushi-tab-item.is-active {
        background: var(--xushi-color-base-200);
        color: var(--xushi-color-base-content);
    }

    .xushi-tab-list--solid.xushi-tab-list--muted .xushi-tab-item:not(.is-active) {
        color: var(--xushi-color-base-content);
        opacity: 0.6;
    }

    /* ── segmented ── */
    .xushi-tab-list--segmented {
        background: var(--xushi-color-base-200);
        border-radius: var(--xushi-radius-box);
        padding: 0.25rem;
    }

    .xushi-tab-list--segmented .xushi-tab-item {
        flex: 1;
        justify-content: center;
    }

    .xushi-tab-list--segmented .xushi-tab-item.is-active {
        background: var(--xushi-color-base-100);
        box-shadow: var(--xushi-shadow);
        color: var(--xushi-color-base-content);
    }

    /* ── vertical ── */
    .xushi-tab--vertical .xushi-tab-list {
        flex-direction: column;
        align-items: stretch;
        padding: 0.25rem 0;
        gap: 0.125rem;
    }

    .xushi-tab--vertical .xushi-tab-list--underline {
        border-bottom: none;
        border-right: 2px solid var(--xushi-color-base-border);
        overflow: unset;
        padding-bottom: 0;
        margin-bottom: 0;
        padding-right: 2px;
        margin-right: -2px;
    }

    .xushi-tab--vertical .xushi-tab-list--underline .xushi-tab-item {
        border-bottom: none;
        border-right: 2px solid transparent;
        margin-bottom: 0;
        margin-right: -2px;
    }

    .xushi-tab--vertical .xushi-tab-list--underline .xushi-tab-item.is-active {
        border-right-color: var(--xushi-tab-accent);
        color: var(--xushi-tab-accent);
    }

    .xushi-tab--vertical .xushi-tab-list--segmented {
        width: fit-content;
    }

    /*
     * Header is a flex column that STRETCHES to match the panels height —
     * this works because .xushi-tab now has align-items: stretch.
     */
    .xushi-tab--vertical .xushi-tab-header {
        flex: 0 0 auto;
        display: flex;
        flex-direction: column;
    }

    .xushi-tab--vertical .xushi-tab-titlebar {
        justify-content: flex-start;
        padding: 0rem 0.5rem 0.25rem;
        flex-shrink: 0;
    }

    /*
     * .xushi-tab-nav is the new wrapper div between titlebar and footer.
     * flex: 1 makes it absorb ALL remaining height inside the header column,
     * so the footer below it is always pushed to the very bottom.
     */
    .xushi-tab--vertical .xushi-tab-nav {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .xushi-tab--vertical .xushi-tab-footer {
        flex-shrink: 0;
        padding: 0.5rem;
    }

    .xushi-tab--fill .xushi-tab-list--segmented .xushi-tab-item,
    .xushi-tab--fill .xushi-tab-list:not(.xushi-tab-list--segmented) .xushi-tab-item {
        flex: 1 1 0;
    }

    /* ── panels ── */
    .xushi-tab-panels {
        flex: 1;
        min-width: 0;
        min-height: 0;
        overflow: hidden;  /* contain the panel scroll within the panels box */
    }

    .xushi-tab-panel {
        width: 100%;
        height: 100%;
        overflow-y: auto;
    }
</style>
@endonce

@once
<script>
    function xushiTab(initial) {
        return {
            active: initial,
            setActive(value) { this.active = value; },
            isActive(value)  { return this.active === value; },
        };
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('xushiTab', xushiTab);
    });
</script>
@endonce

@php
    $accentColor = $color ?? 'var(--xushi-color-accent)';
    $wrapperStyle = collect([
        'display' => 'flex',
        'flex-direction' => $orientation === 'vertical' ? 'row' : 'column',
        'width' => '100%',
        'height' => $height,
        '--xushi-tab-accent' => $accentColor,
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $listStyle = collect([
        'border-radius' => $variant === 'segmented' ? ($radius ?? 'var(--xushi-radius-field)') : null,
        'position' => $sticky ? 'sticky' : null,
        'top' => $sticky ? $stickyoffset : null,
        'align-self' => $sticky ? 'flex-start' : null,
        'flex' => $orientation === 'vertical' ? '0 0 auto' : null,
        'overflow-x' => $scrollable && $orientation === 'horizontal' ? 'auto' : null,
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $panelsStyle = collect([
        'width' => $width,
        'height' => $height,
        'max-height' => $maxheight,
        'max-width' => $maxwidth,
        'background' => $background,
        'border-radius' => $panelradius,
        'padding' => $panelpadding,
        'margin' => $margin,
        'border' => $border,
        'overflow' => null,
        'min-height' => '0',
        'min-width' => '0',
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div
    x-data="xushiTab('{{ $defaultopen ?: $default }}')"
    class="xushi-tab xushi-tab--{{ $orientation }}{{ $fill ? ' xushi-tab--fill' : '' }}"
    style="{{ $wrapperStyle }}"
    {{ $attributes->except(['class', 'style']) }}
>
    <div class="xushi-tab-header">
        <div class="xushi-tab-titlebar">
            @if($title)
                <div class="xushi-tab-title">{{ $title }}</div>
            @endif
            @if(isset($footer) && $orientation === 'horizontal')
                <div class="xushi-tab-footer">{{ $footer }}</div>
            @endif
        </div>

        @if($orientation === 'vertical')
            {{-- .xushi-tab-nav: flex:1 spacer — absorbs all height between titlebar and footer --}}
            <div class="xushi-tab-nav">
                <div
                    class="xushi-tab-list xushi-tab-list--{{ $variant }}{{ $muted ? ' xushi-tab-list--muted' : '' }}"
                    style="{{ $listStyle }}"
                    role="tablist"
                >
                    {{ $tabs }}
                </div>
            </div>
            @if(isset($footer))
                <div class="xushi-tab-footer">{{ $footer }}</div>
            @endif
        @else
            <div
                class="xushi-tab-list xushi-tab-list--{{ $variant }}{{ $muted ? ' xushi-tab-list--muted' : '' }}"
                style="{{ $listStyle }}"
                role="tablist"
            >
                {{ $tabs }}
            </div>
        @endif
    </div>

    <div
        class="xushi-tab-panels"
        style="{{ $panelsStyle }}"
    >
        {{ $slot }}
    </div>
</div>

@props([
    'padding' => '0.5rem',
    'radius' => 'var(--xushi-radius-box)',
    'shadow' => 'var(--xushi-shadow)',
    'background' => 'var(--xushi-color-base-100)',
    'minwidth' => '12rem',
    'margin' => null,
    'border' => '1px',
    'bordercolor' => null,
])

@php
    $style = collect([
        'padding' => $padding,
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'background' => $background,
        'min-width' => $minwidth,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
        'border-style' => 'solid',
    ])->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');
@endphp

@once
<style>
    .xushi-dropdown-root {
        position: relative;
        display: inline-flex;
    }

    .xushi-dropdown-panel {
        position: fixed;
        z-index: var(--xushi-z-dropdown);
        background: var(--xushi-color-base-100);
        border: var(--xushi-border-box) solid var(--xushi-color-base-border);
        border-radius: var(--xushi-radius-box);
        box-shadow: var(--xushi-shadow);
        overflow: hidden;
        min-width: 160px;
        box-sizing: border-box;
    }
</style>
@endonce

@once('xushi-dropdown-alpine')
<script>
    window.xushiDropdown ??= function xushiDropdown() {
        return {
            open: false,
            _id: null,
            hideTimeout: null,
            hoverGroup: null,
            _reposition: null,
            _panel: null,

            init() {
                window.addEventListener('xushi:sidebar-toggled', () => this.hide());
            },

            cancelHide() {
                if (this.hideTimeout) { clearTimeout(this.hideTimeout); this.hideTimeout = null; }
            },
            startReposition(trigger) {
                this.stopReposition();
                this._reposition = () => {
                    if (this._panel) xushiPosition(trigger, this._panel);
                };
                window.addEventListener('scroll', this._reposition, { passive: true, capture: true });
                window.addEventListener('resize', this._reposition, { passive: true });
            },
            stopReposition() {
                if (!this._reposition) return;
                window.removeEventListener('scroll', this._reposition, { capture: true });
                window.removeEventListener('resize', this._reposition);
                this._reposition = null;
            },
            syncHoverGroup(panel) {
                this.hoverGroup = panel?.dataset?.xushiHoverGroup ?? null;
            },
            claimHoverGroup(panel) {
                this.syncHoverGroup(panel);
                if (!this.hoverGroup) return;
                window.__xushiHoverGroups ??= {};
                const active = window.__xushiHoverGroups[this.hoverGroup];
                if (active && active !== this) active.hide();
                window.__xushiHoverGroups[this.hoverGroup] = this;
            },
            releaseHoverGroup() {
                if (!this.hoverGroup || !window.__xushiHoverGroups) return;
                if (window.__xushiHoverGroups[this.hoverGroup] === this) {
                    delete window.__xushiHoverGroups[this.hoverGroup];
                }
            },
            show(trigger, panel) {
                this._panel = panel ?? this._panel;
                this.cancelHide();
                this.claimHoverGroup(this._panel);
                if (!this._id) {
                    this._id = Symbol();
                    XushiOverlayStack.push({ id: this._id, type: 'positioned', hide: () => this.hide() });
                }
                this.open = true;
                this.$nextTick(() => {
                    xushiPosition(trigger, this._panel);
                    this.startReposition(trigger);
                });
            },
            toggle(trigger, panel) {
                this._panel = panel ?? this._panel;
                this.cancelHide();
                this.syncHoverGroup(this._panel);
                this.open = !this.open;
                if (this.open) {
                    this.claimHoverGroup(this._panel);
                    if (!this._id) {
                        this._id = Symbol();
                        XushiOverlayStack.push({ id: this._id, type: 'positioned', hide: () => this.hide() });
                    }
                    this.$nextTick(() => {
                        xushiPosition(trigger, this._panel);
                        this.startReposition(trigger);
                    });
                } else {
                    this.stopReposition();
                    this.releaseHoverGroup();
                    if (this._id) { XushiOverlayStack.pop(this._id); this._id = null; }
                }
            },
            hide() {
                this.cancelHide();
                this.open = false;
                this.stopReposition();
                this.releaseHoverGroup();
                if (this._id) { XushiOverlayStack.pop(this._id); this._id = null; }
            },
            hideSoon(delay = 180) {
                this.cancelHide();
                this.hideTimeout = setTimeout(() => { this.hide(); this.hideTimeout = null; }, delay);
            },
            registerPanel(el) {
                this._panel = el;
            },
        };
    };

    document.addEventListener('alpine:init', () => {
        if (typeof Alpine === 'undefined') return;
        Alpine.data('xushiDropdown', window.xushiDropdown);
    });
</script>
@endonce

<div x-data="xushiDropdown()" class="xushi-dropdown-root" {{ $attributes->except(['class', 'style']) }}>
    @isset($trigger)
        <div x-ref="trigger" x-on:click="toggle($refs.trigger, $refs.panel)">{{ $trigger }}</div>
    @endisset

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-ref="panel"
            @keydown.window.escape="if (open) hide()"
            x-on:click.outside="if ($refs.trigger && $refs.trigger.contains($event.target)) return; hide()"
            x-on:click.stop
            x-bind:class="open ? 'xushi-dropdown-enter' : 'xushi-dropdown-leave'"
            style="position:fixed; z-index:var(--xushi-z-dropdown); {{ $style }}"
        >
            {{ $slot }}
        </div>
    </template>
</div>

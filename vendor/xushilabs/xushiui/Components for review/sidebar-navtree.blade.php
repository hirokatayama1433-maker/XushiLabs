@props([
    'label' => '',
    'name' => null,
    'active' => false,
    'background' => null,
    'color' => null,
    'radius' => null,
    'icon' => 'square-x',
])

@once
    <style>
        .xushinavtree {
            display: flex;
            flex-direction: column;
        }

        .xushinavtree .navtree-items .xushi-navitem-no-icon > a,
        .xushinavtree .navtree-items .xushi-navitem-no-icon > button,
        .xushi-navtree-flyout .xushi-navitem-no-icon > a,
        .xushi-navtree-flyout .xushi-navitem-no-icon > button {
            padding-left: 10px !important;
        }

        .xushinavtree.navtree-open .navtree-chevron {
            transform: rotate(180deg);
        }

        /* Flyout is teleported outside the sidebar but still matches collapsed text-hide rules */
        html.sidebar-collapsed .xushi-navtree-flyout .xushi-sb-text {
            opacity: 1;
            max-width: none;
            pointer-events: auto;
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

@php
    $resolvedLabel = $name ?? $label;
    $bg = $background ?? ($active ? 'var(--xushi-color-base-foreground)' : 'var(--xushi-color-sidebar)');
    $fg = $color ?? ($active ? 'var(--xushi-color-base-content)' : 'var(--xushi-color-sidebar-content)');
    $rad = $radius ?? 'var(--xushi-radius-field)';
    $baseStyle = "
        height: 36px;
        display: flex;
        align-items: center;
        width: 100%;
        border-radius: {$rad};
        cursor: pointer;
        transition: background 150ms ease, color 150ms ease;
        border: none;
        box-sizing: border-box;
        font-family: inherit;
        padding: 0px;
        background: {$bg};
        color: {$fg};
    ";
    $hoverBg = $background ?? 'var(--xushi-color-base-foreground)';
    $hoverColor = $color ?? 'var(--xushi-color-base-content)';
@endphp

<div
    x-data="xushiDropdown()"
    class="xushinavtree"
    style="display:flex; flex-direction:column; position:relative; overflow:visible;"
>
    <button
        type="button"
        {{ $attributes->except('class') }}
        style="{{ $baseStyle }}"
        x-ref="trigger"
        x-on:mouseenter="
            if (document.documentElement.classList.contains('sidebar-collapsed')) {
                cancelHide();
                show($refs.trigger, _panel);
            }
        "
        x-on:mouseleave="
            if (document.documentElement.classList.contains('sidebar-collapsed')) {
                hideSoon(220);
            }
        "
        @if(!$active)
            onmouseover="
                this.style.background='{{ $hoverBg }}';
                this.style.color='{{ $hoverColor }}';
            "
            onmouseout="
                this.style.background='{{ $background ?? 'var(--xushi-custom-sidebar-item-bg)' }}';
                this.style.color='{{ $color ?? 'var(--xushi-custom-sidebar-content)' }}';
            "
        @endif
        x-on:click="
            if (document.documentElement.classList.contains('sidebar-collapsed')) {
                show($refs.trigger, _panel);
                return;
            }

            const tree = $el.closest('.xushinavtree');
            const items = tree.querySelector('.navtree-items');
            const chevron = tree.querySelector('.navtree-chevron');
            const isOpen = tree.classList.contains('navtree-open');
            const nextOpen = !isOpen;

            if (nextOpen) {
                items.style.maxHeight = items.scrollHeight + 'px';
                items.style.opacity = '1';
                chevron.style.transform = 'rotate(180deg)';
                tree.classList.add('navtree-open');
            } else {
                items.style.maxHeight = '0px';
                items.style.opacity = '0';
                chevron.style.transform = 'rotate(0deg)';
                tree.classList.remove('navtree-open');
            }
        "
    >
        <div style="flex-shrink:0; width:40px; height:40px; display:flex; justify-content:center; align-items:center;">
            <xushi:icon name="{{ $icon }}" size="18px"/>
        </div>

        <span class="xushi-sb-text" style="font-size:0.875rem; flex:1; text-align:left; display:flex; align-items:center; min-width:0;">
            {{ $resolvedLabel }}
        </span>

        <span class="xushi-sb-text" style="display:flex; align-items:center; padding-right:0.75rem;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor"
                class="navtree-chevron"
                style="width:0.75rem; height:0.75rem; transition:transform 280ms cubic-bezier(0.4,0,0.2,1); transform:rotate(0deg);">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </span>
    </button>

    {{-- Expanded in-place children --}}
    <div
        class="navtree-items"
        style="display:flex; flex-direction:column; gap:4px; padding-left:38px; overflow:hidden; max-height:0; opacity:0; transition:max-height 150ms cubic-bezier(0.4,0,0.2,1), opacity 150ms ease; position:relative;"
    >
        <span
            aria-hidden="true"
            style="position:absolute; left:18px; top:4px; bottom:4px; width:1.5px; border-radius:9999px; background-color: var(--xushi-color-base-neutral);"
        ></span>
        <div style="height:4px;"></div>
        {{ $slot }}
    </div>

    {{--
        Collapsed flyout — teleported to <body> to escape sidebar overflow clipping.
        registerPanel() hands the DOM node back because $refs don't cross teleport boundaries.
    --}}
    <template x-teleport="body">
        <div
            x-init="registerPanel($el)"
            class="xushi-navtree-flyout"
            x-show="open && document.documentElement.classList.contains('sidebar-collapsed')"
            x-cloak
            data-xushi-placement="right-start"
            data-xushi-hover-group="sidebar-navtree"
            x-on:mouseenter="cancelHide(); show($refs.trigger, _panel)"
            x-on:mouseleave="hideSoon(220)"
            x-on:click.outside="hide()"
            x-on:click.stop
            x-bind:class="open ? 'xushi-dropdown-enter' : 'xushi-dropdown-leave'"
            style="
                position: fixed;
                z-index: var(--xushi-z-dropdown);
                min-width: 200px;
                background: var(--xushi-color-sidebar);
                border-radius: var(--xushi-radius-box);
                border: 1px solid var(--xushi-color-base-neutral);
                box-shadow: var(--xushi-shadow);
                overflow: hidden;
            "
        >
            <div style="padding:0.5rem 0.75rem; font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--xushi-color-base-content); opacity:0.5; border-bottom:1px solid var(--xushi-color-base-border);">
                {{ $resolvedLabel }}
            </div>
            <div
                style="padding:0.375rem; display:flex; flex-direction:column; gap:4px;"
                x-on:click="hide()"
            >
                {{ $slot }}
            </div>
        </div>
    </template>
</div>

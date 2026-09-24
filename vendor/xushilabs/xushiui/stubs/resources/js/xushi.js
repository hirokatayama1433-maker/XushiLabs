/* ============================================================
|  xushi.js - XushiUI JavaScript
|  1. POSITIONING
|  2. ALPINE DATA
|  3. SIDEBAR
|  4. SUBBAR
|  5. THEME
============================================================ */
// import Collapse from '@alpinejs/collapse'

/* ============================================================
|  OVERLAY STACK — global singleton
|  Tracks the open overlay hierarchy. Rules:
|  - Positioned overlays (dropdown, popover) push onto the stack.
|  - Blocking overlays (modal, drawer) CLEAR the whole stack first,
|    then push themselves.
|  - Any overlay calling hide() pops itself and everything above it.
============================================================ */
const XushiOverlayStack = {
    _stack: [], // [{ id, type, hide }]

    push(entry) {
        // Blocking overlays (modal, drawer) close everything first
        if (entry.type === 'blocking') {
            this._closeAllPositioned();
        }
        this._stack.push(entry);
    },

    pop(id) {
        const idx = this._stack.findIndex(e => e.id === id);
        if (idx === -1) return;
        // Close everything above this entry too (e.g. a dropdown
        // opened from inside a popover — closing the popover closes both)
        const removed = this._stack.splice(idx);
        removed.forEach(e => {
            if (e.id !== id) e.hide(); // don't recurse on self
        });
    },

    _closeAllPositioned() {
        const toClose = this._stack.filter(e => e.type === 'positioned');
        this._stack = this._stack.filter(e => e.type !== 'positioned');
        toClose.forEach(e => e.hide());
    },
};

window.XushiOverlayStack = XushiOverlayStack;

/* ============================================================
|  SECTION 1 - SMART POSITIONING
============================================================ */

function xushiPosition(trigger, panel) {
    if (!trigger || !panel) return;

    const tRect = trigger.getBoundingClientRect();
    const gap   = 8;
    const placement = panel.dataset.xushiPlacement ?? 'bottom-start';

    // Reset to measure natural size
    panel.style.top  = '-9999px';
    panel.style.left = '-9999px';

    // Force layout to measure
    panel.getBoundingClientRect();
    const pRect = panel.getBoundingClientRect();
    const vw    = window.innerWidth;
    const vh    = window.innerHeight;

    let top, left;

    if (placement === 'right-center' || placement === 'right-start') {
        left = tRect.right + gap;
        if (left + pRect.width > vw - gap) {
            left = Math.max(gap, tRect.left - pRect.width - gap);
        }
        top = placement === 'right-center'
            ? tRect.top + ((tRect.height - pRect.height) / 2)
            : tRect.top;
    } else {
        // Vertical — prefer below, flip to above if needed
        const spaceBelow = vh - tRect.bottom;
        const spaceAbove = tRect.top;
        top = (spaceBelow >= pRect.height + gap || spaceBelow >= spaceAbove)
            ? tRect.bottom + gap
            : tRect.top - pRect.height - gap;

        left = tRect.left;
        if (left + pRect.width > vw - gap) left = vw - pRect.width - gap;
        if (left < gap) left = gap;
    }

    // Final clamp
    if (top + pRect.height > vh - gap) top = vh - pRect.height - gap;
    if (top  < gap)  top  = gap;
    if (left < gap)  left = gap;

    panel.style.top  = top  + 'px';
    panel.style.left = left + 'px';
}


/* ============================================================
|  SECTION 2 - ALPINE DATA
============================================================ */

function xushiLayout() {
    return {
        sidebarCollapsed: false,
        mobileOpen: false,
    };
}

document.addEventListener('alpine:init', () => {
    if (typeof Alpine === 'undefined') return;
    Alpine.data('xushiLayout', xushiLayout);
});


/* ============================================================
|  SECTION 3 - SIDEBAR
============================================================ */

const Sidebar = {
    scrollRegions:   [],
    savedOpenTrees:  new Set(),

    mobileQuery: window.matchMedia('(max-width: 768px)'),

    get collapsed() {
        return document.documentElement.classList.contains('sidebar-collapsed');
    },

    get mobileOpen() {
        return document.documentElement.classList.contains('sidebar-mobile-open');
    },

    isMobile() {
        return this.mobileQuery.matches;
    },

    openMobile() {
        if (!this.isMobile()) return;
        document.documentElement.classList.add('sidebar-mobile-open');
        // Force expanded behaviour: remove collapsed state while mobile is open
        document.documentElement.classList.remove('sidebar-collapsed');
    },

    closeMobile() {
        document.documentElement.classList.remove('sidebar-mobile-open');
        // Restore collapsed state if the user had it saved on desktop
        if (localStorage.getItem('xushi-sidebar') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    },

    toggleMobile() {
        this.mobileOpen ? this.closeMobile() : this.openMobile();
    },

    get mode() {
        return document.querySelector('.xushisidebar')?.dataset.mode ?? 'collapsible';
    },

    collapse() {
        if (this.isMobile()) {
            this.closeMobile();
            return;
        }

        if (this.mode === 'static') return;
        document.documentElement.classList.add('sidebar-collapsed');
        localStorage.setItem('xushi-sidebar', 'true');
    },

    expand() {
        if (this.isMobile()) {
            this.openMobile();
            return;
        }

        if (this.mode === 'static') return;
        document.documentElement.classList.remove('sidebar-collapsed');
        localStorage.setItem('xushi-sidebar', 'false');
    },

    toggle() {
        if (this.isMobile()) {
            this.toggleMobile();
            return;
        }

        this.collapsed ? this.expand() : this.collapse();
    },

    syncMobileState() {
        const closeIfDesktop = () => {
            if (!this.isMobile()) {
                this.closeMobile();
            }
        };

        if (typeof this.mobileQuery.addEventListener === 'function') {
            this.mobileQuery.addEventListener('change', closeIfDesktop);
        } else if (typeof this.mobileQuery.addListener === 'function') {
            this.mobileQuery.addListener(closeIfDesktop);
        }

        closeIfDesktop();
    },

    syncCollapseState() {
        new MutationObserver(() => {
            window.dispatchEvent(new Event('xushi:sidebar-toggled'));

            if (this.collapsed) {
                this.savedOpenTrees = new Set();
                document.querySelectorAll('.xushinavtree.navtree-open').forEach(tree => {
                    this.savedOpenTrees.add(tree);
                    const items   = tree.querySelector('.navtree-items');
                    const chevron = tree.querySelector('.navtree-chevron');
                    if (items)   { items.style.maxHeight = '0px'; items.style.opacity = '0'; }
                    if (chevron) { chevron.style.transform = 'rotate(0deg)'; }
                    tree.classList.remove('navtree-open');
                });
            } else {
                this.savedOpenTrees.forEach(tree => {
                    if (!document.contains(tree)) return;
                    const items   = tree.querySelector('.navtree-items');
                    const chevron = tree.querySelector('.navtree-chevron');
                    if (items)   { items.style.maxHeight = items.scrollHeight + 'px'; items.style.opacity = '1'; }
                    if (chevron) { chevron.style.transform = 'rotate(180deg)'; }
                    tree.classList.add('navtree-open');
                });
            }
        }).observe(document.documentElement, { attributeFilter: ['class'] });
    },

    updateScrollIndicator(region) {
        const indicator = region.parentElement?.querySelector('[data-sidebar-scroll-indicator]');
        if (!indicator) return;
        const canScroll = region.scrollHeight > region.clientHeight + 1;
        const atBottom  = region.scrollTop + region.clientHeight >= region.scrollHeight - 4;
        const show      = canScroll && !atBottom;
        indicator.style.opacity = show ? '1' : '0';
        indicator.style.height  = show ? '20px' : '0';
    },

    initScrollRegions() {
        this.scrollRegions = Array.from(document.querySelectorAll('[data-sidebar-scroll-region]'));
        this.scrollRegions.forEach(region => {
            new ResizeObserver(() => this.updateScrollIndicator(region)).observe(region);
            region.addEventListener('scroll', () => this.updateScrollIndicator(region), { passive: true });
            this.updateScrollIndicator(region);
        });
    },

    init() {
        if (localStorage.getItem('xushi-sidebar') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed');
        }

        this.syncCollapseState();
        this.syncMobileState();

        document.addEventListener('DOMContentLoaded', () => {
            this.initScrollRegions();

            window.addEventListener('resize', () => {
                document.querySelectorAll('.xushinavtree.navtree-open').forEach(tree => {
                    const items = tree.querySelector('.navtree-items');
                    if (items) items.style.maxHeight = items.scrollHeight + 'px';
                });
                this.scrollRegions.forEach(r => this.updateScrollIndicator(r));
            });

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    document.documentElement.classList.add('sidebar-ready');
                });
            });
        });
    },
};

Sidebar.init();

/* ============================================================
|  SECTION 4 - SUBBAR
============================================================ */

const Subbar = {
    get collapsed() { return document.documentElement.classList.contains('subbar-collapsed'); },
    collapse() { document.documentElement.classList.add('subbar-collapsed'); localStorage.setItem('xushi-subbar', 'true'); },
    expand()   { document.documentElement.classList.remove('subbar-collapsed'); localStorage.setItem('xushi-subbar', 'false'); },
    toggle()   { this.collapsed ? this.expand() : this.collapse(); },
};

if (localStorage.getItem('xushi-subbar') === 'true') Subbar.collapse();

/* ============================================================
|  SECTION 5 - THEME
============================================================ */

const Theme = {
    names: window.XushiThemeNames || ['light', 'dark', 'abyss'],
    cycle: ['light', 'dark', 'abyss'],
    current: localStorage.getItem('xushi-theme') || 'xushitheme-neutral-light-minimalist',

    set(theme) {
        if (this.names.indexOf(theme) < 0) {
            theme = 'xushitheme-neutral-light-minimalist';
        }

        this.current = theme;
        document.documentElement.classList.remove.apply(document.documentElement.classList, this.names);
        document.documentElement.classList.add(theme);
        localStorage.setItem('xushi-theme', theme);
        document.dispatchEvent(new CustomEvent('xushi-theme-changed', {
            detail: { theme }
        }));
    },

    toggle() {
        if      (this.current === 'light') this.set('dark');
        else if (this.current === 'dark')  this.set('light');
        else                               this.set('xushitheme-neutral-light-minimalist');
    },

    next() {
        const idx = this.cycle.indexOf(this.current);
        const next = idx < 0 ? 0 : (idx + 1) % this.cycle.length;
        this.set(this.cycle[next] || 'xushitheme-neutral-light-minimalist');
    },

    isLight() { return this.current === 'light'; },
    isDark()  { return this.current === 'dark';  },
    isAbyss() { return this.current === 'abyss'; },
};

Theme.set(Theme.current);

/* ============================================================
|  EXPORT
============================================================ */

window.Xushi = { Sidebar, Subbar, Theme };


/* ============================================================
|  SECTION 6 - INPUT ACTIONS
============================================================ */

document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-xushi-input-action]');
    if (!btn) return;

    const wrapper = btn.closest('.xushi-input-wrapper');
    const field = wrapper?.querySelector('[data-xushi-input-field]');
    if (!field) return;

    const action = btn.dataset.xushiInputAction;

    if (action === 'clearable') {
        field.value = '';
        field.dispatchEvent(new Event('input', { bubbles: true }));
        field.focus();
        return;
    }

    if (action === 'copyable') {
        navigator.clipboard?.writeText(field.value ?? '').then(() => {
            const copyIcon   = btn.querySelector('[data-xushi-icon-copy]');
            const copiedIcon = btn.querySelector('[data-xushi-icon-copied]');
            if (!copyIcon || !copiedIcon) return;

            copyIcon.style.display   = 'none';
            copiedIcon.style.display = '';

            setTimeout(() => {
                copyIcon.style.display   = '';
                copiedIcon.style.display = 'none';
            }, 1500);
        });
        return;
    }

    if (action === 'viewable') {
        const showIcon = btn.querySelector('[data-xushi-icon-show]');
        const hideIcon = btn.querySelector('[data-xushi-icon-hide]');
        const isPassword = field.type === 'password';

        field.type = isPassword ? 'text' : 'password';

        if (showIcon && hideIcon) {
            showIcon.style.display = isPassword ? 'none' : '';
            hideIcon.style.display = isPassword ? '' : 'none';
        }
        return;
    }
});

function xushiTableSort() {
    return {
        toggle(column) {
            if (!column) return;

            this.$el.dispatchEvent(new CustomEvent('xushi-table-sort', {
                bubbles: true,
                detail: { column }
            }));
        }
    };
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data('xushiTableSort', xushiTableSort);
});


/* ============================================================
|  TOAST GLOBALS
============================================================ */

let _toastId = 0;

function xushiToastIcon(type) {
    const icons = {
        success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:1.125rem;height:1.125rem;"><path d="M20 6 9 17l-5-5"/></svg>',
        danger:  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:1.125rem;height:1.125rem;"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>',
        warning: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:1.125rem;height:1.125rem;"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/><path d="M12 9v4M12 17h.01"/></svg>',
        info:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:1.125rem;height:1.125rem;"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>',
    };
    return icons[type] ?? '';
}

window.XushiToast = {
    show(options) {
        if (typeof options === 'string') options = { body: options };
        document.dispatchEvent(new CustomEvent('xushi-toast', { detail: options }));
    },
    success(body, title)  { this.show({ body, title, type: 'success' }); },
    danger(body, title)   { this.show({ body, title, type: 'danger' });  },
    warning(body, title)  { this.show({ body, title, type: 'warning' }); },
    info(body, title)     { this.show({ body, title, type: 'info' });    },
};

window.xushiToastIcon = xushiToastIcon;


/* ============================================================
|  SIDEBAR SCROLL CHECK
============================================================ */

function xushiSidebarScrollCheck(el) {
    const indicator = el.parentElement?.querySelector('.sidebar-scroll-indicator');
    if (!indicator) return;
    const overflows = el.scrollHeight > el.clientHeight + 1;
    const atBottom  = el.scrollTop + el.clientHeight >= el.scrollHeight - 4;
    const show      = overflows && !atBottom;
    indicator.style.opacity = show ? '1' : '0';
    indicator.style.height  = show ? '20px' : '0';
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-xushi-sidebar-scroll]').forEach(el => {
        new ResizeObserver(() => xushiSidebarScrollCheck(el)).observe(el);
        el.addEventListener('scroll', () => xushiSidebarScrollCheck(el), { passive: true });
        xushiSidebarScrollCheck(el);
    });
});

window.xushiSidebarScrollCheck = xushiSidebarScrollCheck;


/* ============================================================
|  SECTION 7 - FORM COMPONENTS
|  1. Pillbox
|  2. Autocomplete
|  3. OTP Input
|  4. Color Picker
|  5. Date Picker
|  6. Time Picker
|  7. Calendar
============================================================ */

/* ── 1. Pillbox ── */
function xushiPillbox({ tags = [], max = null, disabled = false } = {}) {
    return {
        tags: [...tags],
        max,
        disabled,

        addTag(raw) {
            const tag = String(raw).trim();
            if (!tag || this.tags.includes(tag)) return false;
            if (this.max !== null && this.tags.length >= this.max) return false;
            this.tags.push(tag);
            return true;
        },

        removeTag(index) {
            if (this.disabled) return;
            this.tags.splice(index, 1);
        },

        addTagFromInput(input) {
            const val = input.value.trim().replace(/,$/, '');
            if (val && this.addTag(val)) {
                input.value = '';
            }
        },

        handlePaste(event) {
            const text = event.clipboardData.getData('text');
            const parts = text.split(/[,;\n]+/).map(s => s.trim()).filter(Boolean);
            parts.forEach(p => this.addTag(p));
        },
    };
}

/* ── 2. Autocomplete ── */
function xushiAutocomplete({ options = [], selected = null, freetext = false, emptytext = 'No results found' } = {}) {
    return {
        options,
        selected,
        query: '',
        open: false,
        highlighted: -1,
        freetext,
        emptytext,

        init() {
            if (this.selected !== null) {
                const opt = this.options.find(o => o.value === this.selected);
                this.query = opt ? opt.label : this.selected;
            }
        },

        get filtered() {
            const q = this.query.toLowerCase();
            if (!q) return this.options;
            return this.options.filter(o =>
                o.label.toLowerCase().includes(q) || o.value.toLowerCase().includes(q)
            );
        },

        onInput(val) {
            this.query = val;
            this.open = true;
            this.highlighted = -1;
            if (this.freetext) {
                this.selected = val || null;
            } else if (val === '') {
                this.selected = null;
            }
        },

        onFocus() {
            this.open = true;
            this.$nextTick(() => {
                if (this.$refs.panel) {
                    xushiPosition(this.$refs.trigger ?? this.$el, this.$refs.panel);
                }
            });
        },

        selectOption(opt) {
            this.selected = opt.value;
            this.query = opt.label;
            this.open = false;
            this.highlighted = -1;
            this.$el.dispatchEvent(new CustomEvent('xushi-change', { detail: { value: opt.value, label: opt.label }, bubbles: true }));
        },

        selectHighlighted() {
            if (this.highlighted >= 0 && this.filtered[this.highlighted]) {
                this.selectOption(this.filtered[this.highlighted]);
            } else if (this.freetext && this.query) {
                this.selected = this.query;
                this.open = false;
            } else {
                this.open = false;
            }
        },

        moveHighlight(dir) {
            this.open = true;
            const len = this.filtered.length;
            if (len === 0) return;
            this.highlighted = (this.highlighted + dir + len) % len;
            this.$nextTick(() => {
                const el = this.$refs.panel?.children[this.highlighted + (this.filtered.length === 0 ? 1 : 0)];
                el?.scrollIntoView({ block: 'nearest' });
            });
        },

        clear() {
            this.query = '';
            this.selected = null;
            this.open = false;
            this.$refs.input?.focus();
            this.$el.dispatchEvent(new CustomEvent('xushi-change', { detail: { value: null }, bubbles: true }));
        },

        close() {
            this.open = false;
            if (!this.freetext && this.selected !== null) {
                const opt = this.options.find(o => o.value === this.selected);
                this.query = opt ? opt.label : '';
            }
        },
    };
}

/* ── 3. OTP Input ── */
function xushiOtp({ length = 6, type = 'numeric', name = null } = {}) {
    return {
        digits: Array(length).fill(''),
        length,
        type,
        name,

        getValue() {
            return this.digits.join('');
        },

        isValid(char) {
            if (this.type === 'numeric') return /^[0-9]$/.test(char);
            return /^[A-Za-z0-9]$/.test(char);
        },

        onInput(event, index) {
            const val = event.target.value;
            const char = val.slice(-1).toUpperCase();

            if (!this.isValid(char)) {
                event.target.value = this.digits[index] ?? '';
                return;
            }

            this.digits[index] = char;
            event.target.value = char;

            if (index < this.length - 1) {
                this.$nextTick(() => this.$refs['box' + (index + 1)]?.focus());
            }

            this.$el.dispatchEvent(new CustomEvent('xushi-otp-change', {
                detail: { value: this.getValue(), complete: this.getValue().length === this.length },
                bubbles: true,
            }));
        },

        onKeydown(event, index) {
            if (event.key === 'Backspace') {
                if (this.digits[index]) {
                    this.digits[index] = '';
                    event.target.value = '';
                } else if (index > 0) {
                    this.digits[index - 1] = '';
                    this.$nextTick(() => {
                        const prev = this.$refs['box' + (index - 1)];
                        if (prev) { prev.value = ''; prev.focus(); }
                    });
                }
                event.preventDefault();
            } else if (event.key === 'ArrowLeft' && index > 0) {
                this.$refs['box' + (index - 1)]?.focus();
                event.preventDefault();
            } else if (event.key === 'ArrowRight' && index < this.length - 1) {
                this.$refs['box' + (index + 1)]?.focus();
                event.preventDefault();
            }
        },

        onPaste(event) {
            const text = event.clipboardData.getData('text').replace(/\s/g, '');
            let pos = 0;
            for (let i = 0; i < this.length && pos < text.length; i++) {
                const char = text[pos].toUpperCase();
                if (this.isValid(char)) {
                    this.digits[i] = char;
                    const box = this.$refs['box' + i];
                    if (box) box.value = char;
                    pos++;
                }
            }
            const lastFilled = Math.min(pos, this.length - 1);
            this.$nextTick(() => this.$refs['box' + lastFilled]?.focus());
        },

        onFocus(event, index) {
            event.target.select();
        },
    };
}

/* ── 4. Color Picker ── */
function xushiColorPicker({ value = '#6366f1' } = {}) {
    return {
        color: value,
        hexInput: value.replace('#', ''),
        hexError: false,

        setColor(hex) {
            hex = hex.trim().toLowerCase().replace(/^#/, '');
            if (!/^[0-9a-f]{3}([0-9a-f]{3})?$/.test(hex)) return;
            if (hex.length === 3) {
                hex = hex.split('').map(c => c + c).join('');
            }
            this.color = '#' + hex;
            this.hexInput = hex.toUpperCase();
            this.hexError = false;
            this.$el.dispatchEvent(new CustomEvent('xushi-color-change', { detail: { value: this.color }, bubbles: true }));
        },

        onHexInput(val) {
            this.hexInput = val.toUpperCase().replace(/[^0-9A-F]/g, '');
            this.hexError = false;
            if (this.hexInput.length === 6) {
                this.color = '#' + this.hexInput;
            }
        },

        commitHex() {
            const h = this.hexInput.toLowerCase();
            if (/^[0-9a-f]{6}$/.test(h) || /^[0-9a-f]{3}$/.test(h)) {
                this.setColor(h);
                this.hexError = false;
            } else {
                this.hexError = true;
                this.hexInput = this.color.replace('#', '').toUpperCase();
                setTimeout(() => { this.hexError = false; }, 1500);
            }
        },
    };
}

/* ── Shared calendar engine ── */
const _MONTH_NAMES_LONG  = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const _MONTH_NAMES_SHORT = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const _DAY_NAMES_SHORT   = ['Su','Mo','Tu','We','Th','Fr','Sa'];

function _buildCalendarDays(year, month, min, max, firstDay = 0) {
    const today     = new Date().toISOString().slice(0, 10);
    const firstDate = new Date(year, month, 1);
    const lastDate  = new Date(year, month + 1, 0);
    const startDow  = firstDate.getDay();
    const offset    = (startDow - firstDay + 7) % 7;

    const days = [];

    for (let i = 0; i < offset; i++) {
        const d = new Date(year, month, 1 - (offset - i));
        const iso = d.toISOString().slice(0, 10);
        days.push({ iso, day: d.getDate(), inMonth: false, enabled: false, isToday: iso === today, isFirstOfWeek: days.length % 7 === 0, weekNum: _weekNum(d) });
    }

    for (let d = 1; d <= lastDate.getDate(); d++) {
        const date = new Date(year, month, d);
        const iso  = date.toISOString().slice(0, 10);
        const enabled = (!min || iso >= min) && (!max || iso <= max);
        days.push({ iso, day: d, inMonth: true, enabled, isToday: iso === today, isFirstOfWeek: days.length % 7 === 0, weekNum: _weekNum(date) });
    }

    while (days.length % 7 !== 0) {
        const trailing = new Date(year, month + 1, days.length - offset - lastDate.getDate() + 1);
        const iso = trailing.toISOString().slice(0, 10);
        days.push({ iso, day: trailing.getDate(), inMonth: false, enabled: false, isToday: iso === today, isFirstOfWeek: days.length % 7 === 0, weekNum: _weekNum(trailing) });
    }

    return days;
}

function _weekNum(date) {
    const d = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
    d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
    const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
    return Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
}

/* ── 5. Date Picker ── */
function xushiDatePicker({ value = null, min = null, max = null, format = 'MMM D, YYYY' } = {}) {
    const today = new Date();
    return {
        value,
        min,
        max,
        format,
        open: false,
        view: 'days',
        viewMonth: (value ? new Date(value + 'T00:00:00') : today).getMonth(),
        viewYear: (value ? new Date(value + 'T00:00:00') : today).getFullYear(),

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    const trigger = this.$el;
                    const panel   = this.$refs.panel;
                    if (panel) xushiPosition(trigger, panel);
                });
            }
        },

        close() { this.open = false; },

        selectDate(iso) {
            this.value = iso;
            this.open = false;
            this.$el.dispatchEvent(new CustomEvent('xushi-change', { detail: { value: iso }, bubbles: true }));
        },

        clear() {
            this.value = null;
            this.$el.dispatchEvent(new CustomEvent('xushi-change', { detail: { value: null }, bubbles: true }));
        },

        selectToday() {
            const iso = new Date().toISOString().slice(0, 10);
            this.view = 'days';
            this.viewMonth = new Date().getMonth();
            this.viewYear  = new Date().getFullYear();
            this.selectDate(iso);
        },

        prevMonth() {
            if (this.view === 'years') { this.viewYear -= 12; return; }
            if (this.view === 'months') { this.viewYear--; return; }
            this.viewMonth--;
            if (this.viewMonth < 0) { this.viewMonth = 11; this.viewYear--; }
        },

        nextMonth() {
            if (this.view === 'years') { this.viewYear += 12; return; }
            if (this.view === 'months') { this.viewYear++; return; }
            this.viewMonth++;
            if (this.viewMonth > 11) { this.viewMonth = 0; this.viewYear++; }
        },

        cycleView() {
            if (this.view === 'days')        this.view = 'months';
            else if (this.view === 'months') this.view = 'years';
            else                             this.view = 'days';
        },

        selectMonth(m) { this.viewMonth = m; this.view = 'days'; },
        selectYear(y)  { this.viewYear = y; this.view = 'months'; },

        calendarDays() {
            return _buildCalendarDays(this.viewYear, this.viewMonth, this.min, this.max);
        },

        weekDays() {
            return _DAY_NAMES_SHORT;
        },

        monthNames() { return _MONTH_NAMES_LONG; },

        yearRange() {
            const base = Math.floor(this.viewYear / 12) * 12;
            return Array.from({ length: 12 }, (_, i) => base + i);
        },

        viewLabel() {
            if (this.view === 'years') return `${Math.floor(this.viewYear / 12) * 12} – ${Math.floor(this.viewYear / 12) * 12 + 11}`;
            if (this.view === 'months') return String(this.viewYear);
            return `${_MONTH_NAMES_LONG[this.viewMonth]} ${this.viewYear}`;
        },

        formatDisplay(iso) {
            if (!iso) return '';
            const d = new Date(iso + 'T00:00:00');
            return `${_MONTH_NAMES_SHORT[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
        },

        dayStyle(day) {
            if (!day.inMonth) return 'opacity:0.3; cursor:default; background:transparent; color:var(--xushi-color-base-content);';
            if (!day.enabled) return 'opacity:0.3; cursor:not-allowed; background:transparent; color:var(--xushi-color-base-content);';
            if (this.value === day.iso) return 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;';
            if (day.isToday) return 'background:color-mix(in oklch, var(--xushi-color-primary) 15%, transparent); color:var(--xushi-color-primary); font-weight:600;';
            return 'background:transparent; color:var(--xushi-color-base-content);';
        },
    };
}

/* ── 6. Time Picker ── */
function xushiTimePicker({ value = null, showSeconds = false, meridiem = false, step = 1 } = {}) {
    const parse = (v) => {
        if (!v) return [12, 0, 0, 'AM'];
        const parts = v.split(':').map(Number);
        let h = parts[0] ?? 0, m = parts[1] ?? 0, s = parts[2] ?? 0;
        let period = 'AM';
        if (meridiem) {
            period = h >= 12 ? 'PM' : 'AM';
            h = h % 12 || 12;
        }
        return [h, m, s, period];
    };

    const [initH, initM, initS, initPeriod] = parse(value);

    return {
        open: false,
        hours: initH,
        minutes: initM,
        seconds: initS,
        period: initPeriod,
        showSeconds,
        meridiem,
        step,

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    if (this.$refs.panel) xushiPosition(this.$el, this.$refs.panel);
                });
            }
        },

        close() { this.open = false; },

        pad(n) { return String(n).padStart(2, '0'); },

        step(field, amount) {
            if (field === 'hours') {
                const max = this.meridiem ? 12 : 23;
                const min = this.meridiem ? 1  : 0;
                this.hours = ((this.hours - min + amount + (max - min + 1)) % (max - min + 1)) + min;
            } else if (field === 'minutes') {
                this.minutes = ((this.minutes + amount) + 60) % 60;
            } else if (field === 'seconds') {
                this.seconds = ((this.seconds + amount) + 60) % 60;
            }
        },

        getValue() {
            let h = this.hours;
            if (this.meridiem) {
                if (this.period === 'PM' && h !== 12) h += 12;
                if (this.period === 'AM' && h === 12) h = 0;
            }
            let out = `${this.pad(h)}:${this.pad(this.minutes)}`;
            if (this.showSeconds) out += `:${this.pad(this.seconds)}`;
            return out;
        },

        clear() {
            this.hours = 12; this.minutes = 0; this.seconds = 0; this.period = 'AM';
        },
    };
}

/* ── 7. Standalone Calendar ── */
function xushiCalendar({ value = null, min = null, max = null, mode = 'single', firstDay = 0, weekNumbers = false } = {}) {
    const today = new Date();
    const initDate = value ? new Date(value + 'T00:00:00') : today;
    return {
        selected: value ? [value] : [],
        rangeStart: null,
        min,
        max,
        mode,
        firstDay,
        weekNumbers,
        view: 'days',
        viewMonth: initDate.getMonth(),
        viewYear: initDate.getFullYear(),

        isSelected(iso) {
            if (this.mode === 'range') {
                if (this.selected.length === 2) return iso >= this.selected[0] && iso <= this.selected[1];
                return this.selected.includes(iso);
            }
            return this.selected.includes(iso);
        },

        selectDate(iso) {
            if (this.mode === 'single') {
                this.selected = [iso];
            } else if (this.mode === 'multiple') {
                const idx = this.selected.indexOf(iso);
                if (idx >= 0) this.selected.splice(idx, 1);
                else this.selected.push(iso);
            } else if (this.mode === 'range') {
                if (this.rangeStart === null || this.selected.length === 2) {
                    this.rangeStart = iso;
                    this.selected = [iso];
                } else {
                    const start = this.rangeStart < iso ? this.rangeStart : iso;
                    const end   = this.rangeStart < iso ? iso : this.rangeStart;
                    this.selected = [start, end];
                    this.rangeStart = null;
                }
            }
            this.$el.dispatchEvent(new CustomEvent('xushi-change', { detail: { value: this.mode === 'single' ? this.selected[0] : this.selected }, bubbles: true }));
        },

        clearSelection() { this.selected = []; this.rangeStart = null; },

        selectToday() {
            const iso = new Date().toISOString().slice(0, 10);
            this.view = 'days';
            this.viewMonth = new Date().getMonth();
            this.viewYear  = new Date().getFullYear();
            this.selectDate(iso);
        },

        prevMonth() {
            if (this.view === 'years')  { this.viewYear -= 12; return; }
            if (this.view === 'months') { this.viewYear--; return; }
            this.viewMonth--;
            if (this.viewMonth < 0) { this.viewMonth = 11; this.viewYear--; }
        },

        nextMonth() {
            if (this.view === 'years')  { this.viewYear += 12; return; }
            if (this.view === 'months') { this.viewYear++; return; }
            this.viewMonth++;
            if (this.viewMonth > 11) { this.viewMonth = 0; this.viewYear++; }
        },

        cycleView() {
            if (this.view === 'days')        this.view = 'months';
            else if (this.view === 'months') this.view = 'years';
            else                             this.view = 'days';
        },

        selectMonth(m) { this.viewMonth = m; this.view = 'days'; },
        selectYear(y)  { this.viewYear = y; this.view = 'months'; },

        calendarDays() {
            return _buildCalendarDays(this.viewYear, this.viewMonth, this.min, this.max, this.firstDay);
        },

        weekDays() {
            const base = _DAY_NAMES_SHORT;
            return [...base.slice(this.firstDay), ...base.slice(0, this.firstDay)];
        },

        monthNames()  { return _MONTH_NAMES_LONG; },

        yearRange() {
            const base = Math.floor(this.viewYear / 12) * 12;
            return Array.from({ length: 12 }, (_, i) => base + i);
        },

        viewLabel() {
            if (this.view === 'years') return `${Math.floor(this.viewYear / 12) * 12} – ${Math.floor(this.viewYear / 12) * 12 + 11}`;
            if (this.view === 'months') return String(this.viewYear);
            return `${_MONTH_NAMES_LONG[this.viewMonth]} ${this.viewYear}`;
        },

        dayStyle(day) {
            if (!day.inMonth)  return 'opacity:0.3; cursor:default; background:transparent; color:var(--xushi-color-base-content);';
            if (!day.enabled)  return 'opacity:0.3; cursor:not-allowed; background:transparent; color:var(--xushi-color-base-content);';
            if (this.isSelected(day.iso)) {
                const isEdge = this.mode === 'range' && this.selected.length === 2
                    && (day.iso === this.selected[0] || day.iso === this.selected[1]);
                if (this.mode === 'range' && !isEdge && this.selected.length === 2) {
                    return 'background:color-mix(in oklch, var(--xushi-color-primary) 15%, transparent); color:var(--xushi-color-primary);';
                }
                return 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;';
            }
            if (day.isToday) return 'background:color-mix(in oklch, var(--xushi-color-primary) 12%, transparent); color:var(--xushi-color-primary); font-weight:600;';
            return 'background:transparent; color:var(--xushi-color-base-content);';
        },
    };
}

/* ── Register all form components ── */
document.addEventListener('alpine:init', () => {
    if (typeof Alpine === 'undefined') return;
    Alpine.data('xushiPillbox',      xushiPillbox);
    Alpine.data('xushiAutocomplete', xushiAutocomplete);
    Alpine.data('xushiOtp',          xushiOtp);
    Alpine.data('xushiColorPicker',  xushiColorPicker);
    Alpine.data('xushiDatePicker',   xushiDatePicker);
    Alpine.data('xushiTimePicker',   xushiTimePicker);
    Alpine.data('xushiCalendar',     xushiCalendar);
});

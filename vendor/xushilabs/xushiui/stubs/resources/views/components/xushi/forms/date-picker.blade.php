@props([
    'name'        => null,
    'value'       => null,
    'min'         => null,
    'max'         => null,
    'placeholder' => 'Pick a date',
    'format'      => 'MMM D, YYYY',
    'disabled'    => false,
    'clearable'   => true,
    'variant'     => 'outline',
    'color'       => 'base',
    'radius'      => 'var(--xushi-radius-field)',
    'shadow'      => null,
    'margin'      => null,
    'border'      => 'var(--xushi-border-field)',
    'bordercolor' => null,
])

@once
<style>
    .xushi-date-picker { position: relative; width: 100%; }

    .xushi-date-picker-panel {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        z-index: var(--xushi-z-dropdown);
        background: var(--xushi-color-base-foreground);
        border-radius: var(--xushi-radius-box);
        box-shadow: var(--xushi-shadow);
        border: 1px solid var(--xushi-color-base-border);
        padding: 0.875rem;
        min-width: 18rem;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
    }

    .xushi-dp-nav-btn {
        width: 2rem;
        height: 2rem;
        border: none;
        background: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--xushi-radius-selector);
        color: var(--xushi-color-base-content);
        transition: background 120ms;
    }

    .xushi-dp-nav-btn:hover { background: var(--xushi-color-base-neutral); }

    .xushi-dp-day-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 2.125rem;
        border-radius: var(--xushi-radius-selector);
        border: none;
        font-family: inherit;
        font-size: 0.8125rem;
        cursor: pointer;
        transition: background 100ms ease, color 100ms ease;
        background: transparent;
        color: var(--xushi-color-base-content);
    }

    .xushi-dp-day-btn:disabled {
        opacity: 0.25;
        cursor: default;
    }

    .xushi-dp-day-btn:not(:disabled):hover {
        background: var(--xushi-color-base-neutral);
    }

    .xushi-dp-grid-picker-btn {
        padding: 0.625rem;
        border-radius: var(--xushi-radius-selector);
        border: none;
        font-family: inherit;
        font-size: 0.8125rem;
        cursor: pointer;
        transition: background 100ms;
        background: transparent;
        color: var(--xushi-color-base-content);
    }

    .xushi-dp-grid-picker-btn:hover {
        background: var(--xushi-color-base-neutral);
    }
</style>
@endonce

@once
<script>
    (function () {
        if (window._xushiDatePickerRegistered) return;
        window._xushiDatePickerRegistered = true;

        const MONTH_LONG  = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        const MONTH_SHORT = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const DAY_SHORT   = ['Su','Mo','Tu','We','Th','Fr','Sa'];

        function buildDays(year, month, min, max) {
            const today     = new Date().toISOString().slice(0, 10);
            const firstDate = new Date(year, month, 1);
            const lastDate  = new Date(year, month + 1, 0);
            const offset    = firstDate.getDay();
            const days      = [];

            for (let i = 0; i < offset; i++) {
                const d   = new Date(year, month, 1 - (offset - i));
                const iso = d.toISOString().slice(0, 10);
                days.push({ iso, day: d.getDate(), inMonth: false, enabled: false, isToday: iso === today });
            }
            for (let d = 1; d <= lastDate.getDate(); d++) {
                const date    = new Date(year, month, d);
                const iso     = date.toISOString().slice(0, 10);
                const enabled = (!min || iso >= min) && (!max || iso <= max);
                days.push({ iso, day: d, inMonth: true, enabled, isToday: iso === today });
            }
            while (days.length % 7 !== 0) {
                const trailing = new Date(year, month + 1, days.length - offset - lastDate.getDate() + 1);
                const iso      = trailing.toISOString().slice(0, 10);
                days.push({ iso, day: trailing.getDate(), inMonth: false, enabled: false, isToday: iso === today });
            }
            return days;
        }

        function xushiDatePicker({ value = null, min = null, max = null, format = 'MMM D, YYYY' } = {}) {
            const today    = new Date();
            const initDate = value ? new Date(value + 'T00:00:00') : today;
            return {
                value, min, max, format,
                open:      false,
                view:      'days',
                viewMonth: initDate.getMonth(),
                viewYear:  initDate.getFullYear(),

                toggle() { this.open = !this.open; },
                close()  { this.open = false; },

                selectDate(iso) {
                    this.value = iso;
                    this.open  = false;
                    this.$el.dispatchEvent(new CustomEvent('xushi:datepicker-change', { detail: { value: iso }, bubbles: true }));
                },

                clear() {
                    this.value = null;
                    this.$el.dispatchEvent(new CustomEvent('xushi:datepicker-change', { detail: { value: null }, bubbles: true }));
                },

                selectToday() {
                    const iso      = new Date().toISOString().slice(0, 10);
                    this.view      = 'days';
                    this.viewMonth = new Date().getMonth();
                    this.viewYear  = new Date().getFullYear();
                    this.selectDate(iso);
                },

                prevMonth() {
                    if (this.view === 'years')  { this.viewYear -= 12; return; }
                    if (this.view === 'months') { this.viewYear--;     return; }
                    if (--this.viewMonth < 0)  { this.viewMonth = 11; this.viewYear--; }
                },

                nextMonth() {
                    if (this.view === 'years')  { this.viewYear += 12; return; }
                    if (this.view === 'months') { this.viewYear++;     return; }
                    if (++this.viewMonth > 11) { this.viewMonth = 0;  this.viewYear++; }
                },

                cycleView() {
                    this.view = this.view === 'days' ? 'months' : this.view === 'months' ? 'years' : 'days';
                },

                selectMonth(m) { this.viewMonth = m; this.view = 'days'; },
                selectYear(y)  { this.viewYear  = y; this.view = 'months'; },

                calendarDays() { return buildDays(this.viewYear, this.viewMonth, this.min, this.max); },
                weekDays()     { return DAY_SHORT; },
                monthNames()   { return MONTH_LONG; },

                yearRange() {
                    const base = Math.floor(this.viewYear / 12) * 12;
                    return Array.from({ length: 12 }, (_, i) => base + i);
                },

                viewLabel() {
                    if (this.view === 'years') {
                        const base = Math.floor(this.viewYear / 12) * 12;
                        return `${base} – ${base + 11}`;
                    }
                    if (this.view === 'months') return String(this.viewYear);
                    return `${MONTH_LONG[this.viewMonth]} ${this.viewYear}`;
                },

                formatDisplay(iso) {
                    if (!iso) return '';
                    const d = new Date(iso + 'T00:00:00');
                    return `${MONTH_SHORT[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
                },

                dayStyle(day) {
                    if (!day.inMonth || !day.enabled) return '';
                    if (this.value === day.iso)        return 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;';
                    if (day.isToday)                   return 'background:color-mix(in oklch, var(--xushi-color-primary) 15%, transparent); color:var(--xushi-color-primary); font-weight:600;';
                    return '';
                },
            };
        }

        document.addEventListener('alpine:init', () => {
            try { Alpine.data('xushiDatePicker', xushiDatePicker); }
            catch (e) { console.error('[Xushi] xushiDatePicker failed to register', e); }
        });
    })();
</script>
@endonce

@php
    $variantStyles = [
        'outline' => [
            'base'    => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-base-border)'],
            'primary' => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-primary)'],
            'danger'  => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-danger)'],
        ],
        'soft' => [
            'base'    => ['background' => 'var(--xushi-color-base-neutral)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 10%, var(--xushi-color-base-foreground))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['outline']['base'];

    $style = collect(array_merge($resolved, [
        'border-radius' => $radius,
        'box-shadow'    => $shadow,
        'margin'        => $margin,
        'border-width'  => $border,
        'border-color'  => $bordercolor ?? $resolved['border-color'],
        'opacity'       => $disabled ? '0.5' : null,
    ]))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div
    x-data="xushiDatePicker({
        value: {{ $value ? json_encode($value) : 'null' }},
        min: {{ $min ? json_encode($min) : 'null' }},
        max: {{ $max ? json_encode($max) : 'null' }},
        format: {{ json_encode($format) }}
    })"
    class="xushi-date-picker"
    @click.outside="close()"
    {{ $attributes->except(['class', 'style']) }}
>
    @if($name)
        <input type="hidden" name="{{ $name }}" :value="value ?? ''">
    @endif

    {{-- Trigger --}}
    <div
        style="{{ $style }}; height:var(--xushi-size-field); padding:0 0.875rem; display:flex; align-items:center; gap:0.5rem; border-style:solid; cursor:pointer; box-sizing:border-box;"
        @click="@if(!$disabled) toggle() @endif"
        tabindex="0"
        @keydown.enter.prevent="toggle()"
        @keydown.space.prevent="toggle()"
        @keydown.escape="close()"
        role="button"
        :aria-expanded="open"
    >
        <span style="flex-shrink:0; display:flex; opacity:0.45;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:0.9375rem;height:0.9375rem;">
                <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
        </span>

        <span style="flex:1; font-size:0.875rem;" :style="!value ? 'opacity:0.45;' : ''" x-text="value ? formatDisplay(value) : '{{ $placeholder }}'"></span>

        @if($clearable)
            <button type="button" x-show="value !== null" x-cloak @click.stop="clear()"
                style="display:flex; align-items:center; justify-content:center; width:1.125rem; height:1.125rem; border:none; background:transparent; cursor:pointer; padding:0; color:inherit; opacity:0.5; flex-shrink:0; transition:opacity 120ms;"
                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'" aria-label="Clear date">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:0.75rem;height:0.75rem;">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        @endif

        <span style="flex-shrink:0; display:flex; opacity:0.4; transition:transform 200ms ease;" :style="open ? 'transform:rotate(180deg)' : ''">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </span>
    </div>

    {{-- Panel --}}
    <div x-show="open" x-cloak class="xushi-date-picker-panel" style="display:none;">

        {{-- Navigation --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem;">
            <button type="button" class="xushi-dp-nav-btn" @click="prevMonth()" aria-label="Previous">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m15 6-6 6 6 6"/></svg>
            </button>
            <button type="button" @click="cycleView()"
                style="border:none; background:transparent; cursor:pointer; font-size:0.9375rem; font-weight:700; font-family:inherit; color:var(--xushi-color-base-content); padding:0.25rem 0.625rem; border-radius:var(--xushi-radius-selector); transition:background 120ms;"
                onmouseover="this.style.background='var(--xushi-color-base-neutral)'"
                onmouseout="this.style.background='transparent'"
                x-text="viewLabel()"></button>
            <button type="button" class="xushi-dp-nav-btn" @click="nextMonth()" aria-label="Next">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m9 6 6 6-6 6"/></svg>
            </button>
        </div>

        {{-- Days view --}}
        <div x-show="view === 'days'">
            <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:2px; margin-bottom:0.25rem;">
                <template x-for="day in weekDays()" :key="day">
                    <div style="text-align:center; font-size:0.6875rem; font-weight:700; color:var(--xushi-color-base-content); opacity:0.4; padding:0.25rem 0; text-transform:uppercase; letter-spacing:0.06em;" x-text="day"></div>
                </template>
            </div>
            <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:2px;">
                <template x-for="day in calendarDays()" :key="day.iso">
                    <button
                        type="button"
                        class="xushi-dp-day-btn"
                        @click="day.enabled && day.inMonth && selectDate(day.iso)"
                        :disabled="!day.enabled || !day.inMonth"
                        :style="dayStyle(day)"
                        :aria-label="day.iso"
                        :aria-selected="value === day.iso"
                        x-text="day.day"
                    ></button>
                </template>
            </div>
        </div>

        {{-- Months view --}}
        <div x-show="view === 'months'" style="display:grid; grid-template-columns:repeat(3,1fr); gap:0.375rem;">
            <template x-for="(m, i) in monthNames()" :key="i">
                <button type="button" class="xushi-dp-grid-picker-btn" @click="selectMonth(i)"
                    :style="viewMonth === i ? 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;' : ''"
                    x-text="m"></button>
            </template>
        </div>

        {{-- Years view --}}
        <div x-show="view === 'years'" style="display:grid; grid-template-columns:repeat(4,1fr); gap:0.375rem; max-height:14rem; overflow-y:auto;">
            <template x-for="yr in yearRange()" :key="yr">
                <button type="button" class="xushi-dp-grid-picker-btn" @click="selectYear(yr)"
                    :style="viewYear === yr ? 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;' : ''"
                    x-text="yr"></button>
            </template>
        </div>

        {{-- Footer --}}
        <div style="margin-top:0.75rem; padding-top:0.625rem; border-top:1px solid var(--xushi-color-base-border); display:flex; justify-content:center;">
            <button type="button" @click="selectToday()"
                style="border:none; background:transparent; cursor:pointer; font-size:0.8125rem; font-family:inherit; font-weight:500; color:var(--xushi-color-primary); padding:0.25rem 0.75rem; border-radius:var(--xushi-radius-selector); transition:background 120ms;"
                onmouseover="this.style.background='color-mix(in oklch, var(--xushi-color-primary) 10%, transparent)'"
                onmouseout="this.style.background='transparent'"
            >Today</button>
        </div>

    </div>
</div>
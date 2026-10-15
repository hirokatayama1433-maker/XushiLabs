@props([
    'name'        => null,
    'value'       => null,
    'min'         => null,
    'max'         => null,
    'mode'        => 'single',
    'showtoday'   => true,
    'weeknumbers' => false,
    'firstday'    => '0',
    'radius'      => null,
    'shadow'      => null,
    'border'      => null,
    'width'       => null,
    'margin'      => null,
])

@once
<style>
    .xushi-calendar { box-sizing: border-box; }

    .xushi-cal-nav-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border: none;
        background: transparent;
        border-radius: var(--xushi-radius-selector);
        cursor: pointer;
        color: var(--xushi-color-base-content);
        transition: background 120ms;
    }

    .xushi-cal-nav-btn:hover { background: var(--xushi-color-base-200); }

    .xushi-cal-day-btn {
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

    .xushi-cal-day-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .xushi-cal-day-btn:not(:disabled):hover {
        background: var(--xushi-color-base-200);
    }
</style>
@endonce

@once
<script>
    (function () {
        if (window._xushiCalendarRegistered) return;
        window._xushiCalendarRegistered = true;

        const MONTH_LONG  = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        const MONTH_SHORT = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const DAY_SHORT   = ['Su','Mo','Tu','We','Th','Fr','Sa'];

        function buildDays(year, month, min, max, firstDay) {
            firstDay = parseInt(firstDay) || 0;
            const today     = new Date().toISOString().slice(0, 10);
            const firstDate = new Date(year, month, 1);
            const lastDate  = new Date(year, month + 1, 0);
            const offset    = (firstDate.getDay() - firstDay + 7) % 7;
            const days      = [];

            for (let i = 0; i < offset; i++) {
                const d   = new Date(year, month, 1 - (offset - i));
                const iso = d.toISOString().slice(0, 10);
                days.push({ iso, day: d.getDate(), inMonth: false, enabled: false, isToday: iso === today, isFirstOfWeek: days.length % 7 === 0, weekNum: weekNum(d) });
            }

            for (let d = 1; d <= lastDate.getDate(); d++) {
                const date    = new Date(year, month, d);
                const iso     = date.toISOString().slice(0, 10);
                const enabled = (!min || iso >= min) && (!max || iso <= max);
                days.push({ iso, day: d, inMonth: true, enabled, isToday: iso === today, isFirstOfWeek: days.length % 7 === 0, weekNum: weekNum(date) });
            }

            while (days.length % 7 !== 0) {
                const trailing = new Date(year, month + 1, days.length - offset - lastDate.getDate() + 1);
                const iso      = trailing.toISOString().slice(0, 10);
                days.push({ iso, day: trailing.getDate(), inMonth: false, enabled: false, isToday: iso === today, isFirstOfWeek: days.length % 7 === 0, weekNum: weekNum(trailing) });
            }

            return days;
        }

        function weekNum(date) {
            const d = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
            d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
            const y = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
            return Math.ceil((((d - y) / 86400000) + 1) / 7);
        }

        function xushiCalendar({ value = null, min = null, max = null, mode = 'single', firstDay = 0, weekNumbers = false } = {}) {
            const today    = new Date();
            const initDate = value ? new Date(value + 'T00:00:00') : today;

            return {
                selected:   value ? [value] : [],
                rangeStart: null,
                min, max, mode, firstDay, weekNumbers,
                view:       'days',
                viewMonth:  initDate.getMonth(),
                viewYear:   initDate.getFullYear(),

                isSelected(iso) {
                    if (this.mode === 'range' && this.selected.length === 2)
                        return iso >= this.selected[0] && iso <= this.selected[1];
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
                            this.selected   = [iso];
                        } else {
                            const s = this.rangeStart < iso ? this.rangeStart : iso;
                            const e = this.rangeStart < iso ? iso : this.rangeStart;
                            this.selected   = [s, e];
                            this.rangeStart = null;
                        }
                    }
                    this.$el.dispatchEvent(new CustomEvent('xushi:calendar-change', {
                        detail: { value: this.mode === 'single' ? this.selected[0] : this.selected },
                        bubbles: true,
                    }));
                },

                clearSelection() { this.selected = []; this.rangeStart = null; },

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

                calendarDays() { return buildDays(this.viewYear, this.viewMonth, this.min, this.max, this.firstDay); },

                weekDays() {
                    const fd = parseInt(this.firstDay) || 0;
                    return [...DAY_SHORT.slice(fd), ...DAY_SHORT.slice(0, fd)];
                },

                monthNames() { return MONTH_LONG; },

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

                dayStyle(day) {
                    if (!day.inMonth || !day.enabled) return '';
                    if (this.isSelected(day.iso)) {
                        if (this.mode === 'range' && this.selected.length === 2
                            && day.iso !== this.selected[0] && day.iso !== this.selected[1])
                            return 'background:color-mix(in oklch, var(--xushi-color-primary) 15%, transparent); color:var(--xushi-color-primary);';
                        return 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;';
                    }
                    if (day.isToday) return 'background:color-mix(in oklch, var(--xushi-color-primary) 12%, transparent); color:var(--xushi-color-primary); font-weight:600;';
                    return '';
                },
            };
        }

        document.addEventListener('alpine:init', () => {
            try {
                Alpine.data('xushiCalendar', xushiCalendar);
            } catch (e) {
                console.error('[Xushi] xushiCalendar failed to register', e);
            }
        });
    })();
</script>
@endonce

@php
    $style = collect([
        'display'       => 'flex',
        'flex-direction'=> 'column',
        'background'    => 'var(--xushi-color-base-foreground)',
        'border-radius' => $radius ?? 'var(--xushi-radius-box)',
        'border'        => $border ?? '1px solid var(--xushi-color-base-border)',
        'box-shadow'    => $shadow,
        'width'         => $width ?? 'fit-content',
        'padding'       => '0.875rem',
        'margin'        => $margin,
        'box-sizing'    => 'border-box',
        'min-width'     => '18rem',
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $cols = $weeknumbers ? '1.5rem repeat(7,1fr)' : 'repeat(7,1fr)';
@endphp

<div
    x-data="xushiCalendar({
        value: {{ $value ? json_encode($value) : 'null' }},
        min: {{ $min ? json_encode($min) : 'null' }},
        max: {{ $max ? json_encode($max) : 'null' }},
        mode: '{{ $mode }}',
        firstDay: {{ $firstday }},
        weekNumbers: {{ $weeknumbers ? 'true' : 'false' }}
    })"
    class="xushi-calendar"
    style="{{ $style }}"
    {{ $attributes->except(['class', 'style']) }}
>
    {{-- Hidden inputs --}}
    @if($name)
        <template x-if="mode === 'single'">
            <input type="hidden" name="{{ $name }}" :value="selected[0] ?? ''">
        </template>
        <template x-if="mode !== 'single'">
            <template x-for="(d, i) in selected" :key="i">
                <input type="hidden" name="{{ $name }}[]" :value="d">
            </template>
        </template>
    @endif

    {{-- Navigation --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem;">
        <button type="button" class="xushi-cal-nav-btn" @click="prevMonth()" aria-label="Previous month">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m15 6-6 6 6 6"/></svg>
        </button>

        <button
            type="button"
            @click="cycleView()"
            style="border:none; background:transparent; cursor:pointer; font-size:0.9375rem; font-weight:700; font-family:inherit; color:var(--xushi-color-base-content); padding:0.25rem 0.625rem; border-radius:var(--xushi-radius-selector); transition:background 120ms;"
            onmouseover="this.style.background='var(--xushi-color-base-200)'"
            onmouseout="this.style.background='transparent'"
            x-text="viewLabel()"
        ></button>

        <button type="button" class="xushi-cal-nav-btn" @click="nextMonth()" aria-label="Next month">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m9 6 6 6-6 6"/></svg>
        </button>
    </div>

    {{-- Days view --}}
    <div x-show="view === 'days'">
        {{-- Weekday headers --}}
        <div style="display:grid; grid-template-columns:{{ $cols }}; gap:2px; margin-bottom:0.25rem;">
            @if($weeknumbers)
                <div></div>
            @endif
            <template x-for="day in weekDays()" :key="day">
                <div style="text-align:center; font-size:0.6875rem; font-weight:700; color:var(--xushi-color-base-content); opacity:0.4; padding:0.25rem 0; text-transform:uppercase; letter-spacing:0.06em;" x-text="day"></div>
            </template>
        </div>

        {{-- Day cells --}}
        <div style="display:grid; grid-template-columns:{{ $cols }}; gap:2px;">
            <template x-for="day in calendarDays()" :key="day.iso">
                @if($weeknumbers)
                    <template x-if="day.isFirstOfWeek">
                        <div style="display:flex; align-items:center; justify-content:center; font-size:0.6875rem; color:var(--xushi-color-base-content); opacity:0.35;" x-text="day.weekNum"></div>
                    </template>
                @endif

                <button
                    type="button"
                    class="xushi-cal-day-btn"
                    @click="day.enabled && selectDate(day.iso)"
                    :disabled="!day.enabled || !day.inMonth"
                    :style="dayStyle(day)"
                    :style2="!day.inMonth ? 'opacity:0.25;' : ''"
                    :aria-selected="isSelected(day.iso)"
                    :aria-label="day.iso"
                    x-text="day.day"
                ></button>
            </template>
        </div>
    </div>

    {{-- Month picker --}}
    <div x-show="view === 'months'" style="display:grid; grid-template-columns:repeat(3,1fr); gap:0.375rem;">
        <template x-for="(m, i) in monthNames()" :key="i">
            <button
                type="button"
                @click="selectMonth(i)"
                style="padding:0.625rem; border-radius:var(--xushi-radius-selector); border:none; font-family:inherit; font-size:0.8125rem; cursor:pointer; transition:background 100ms;"
                :style="viewMonth === i ? 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;' : 'background:transparent; color:var(--xushi-color-base-content);'"
                x-text="m"
                onmouseover="if(!this.style.background.includes('primary')) this.style.background='var(--xushi-color-base-200)'"
                onmouseout="if(!this.style.background.includes('primary')) this.style.background='transparent'"
            ></button>
        </template>
    </div>

    {{-- Year picker --}}
    <div x-show="view === 'years'" style="display:grid; grid-template-columns:repeat(4,1fr); gap:0.375rem; max-height:14rem; overflow-y:auto;">
        <template x-for="yr in yearRange()" :key="yr">
            <button
                type="button"
                @click="selectYear(yr)"
                style="padding:0.5rem; border-radius:var(--xushi-radius-selector); border:none; font-family:inherit; font-size:0.8125rem; cursor:pointer; transition:background 100ms;"
                :style="viewYear === yr ? 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;' : 'background:transparent; color:var(--xushi-color-base-content);'"
                x-text="yr"
                onmouseover="if(!this.style.background.includes('primary')) this.style.background='var(--xushi-color-base-200)'"
                onmouseout="if(!this.style.background.includes('primary')) this.style.background='transparent'"
            ></button>
        </template>
    </div>

    {{-- Footer --}}
    @if($showtoday)
        <div style="margin-top:0.75rem; padding-top:0.625rem; border-top:1px solid var(--xushi-color-base-border); display:flex; align-items:center; justify-content:space-between;">
            <button
                type="button"
                @click="clearSelection()"
                x-show="selected.length > 0"
                x-cloak
                style="border:none; background:transparent; cursor:pointer; font-size:0.8125rem; font-family:inherit; color:var(--xushi-color-base-content); opacity:0.5; padding:0.25rem 0.375rem; border-radius:var(--xushi-radius-selector);"
            >Clear</button>
            <button
                type="button"
                @click="selectToday()"
                style="border:none; background:transparent; cursor:pointer; font-size:0.8125rem; font-family:inherit; font-weight:500; color:var(--xushi-color-primary); padding:0.25rem 0.75rem; border-radius:var(--xushi-radius-selector); margin-left:auto; transition:background 120ms;"
                onmouseover="this.style.background='color-mix(in oklch, var(--xushi-color-primary) 10%, transparent)'"
                onmouseout="this.style.background='transparent'"
            >Today</button>
        </div>
    @endif
</div>